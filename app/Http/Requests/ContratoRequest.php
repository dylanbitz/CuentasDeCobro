<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\CuentaCobro;

class ContratoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Solo usuarios con rol de contratación pueden hacer estas requests
        return $this->user() && $this->user()->hasRole('contratacion');
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $rules = [
            'user_id' => 'required|exists:users,id',
            'proyecto_servicio' => 'required|string|min:3|max:255',
            'descripcion' => 'nullable|string|max:1000',
            'valor' => 'required|numeric|min:0|max:999999999',
            'fecha_emision' => 'required|date|before_or_equal:today',
            'estado' => 'required|in:' . implode(',', array_keys(CuentaCobro::getEstados())),
            'ruta_archivo' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240'
        ];

        // Para actualizaciones, hacemos el archivo opcional
        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules['ruta_archivo'] = 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240';
        }

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'user_id.required' => 'Debe seleccionar un proveedor.',
            'user_id.exists' => 'El proveedor seleccionado no existe.',
            'proyecto_servicio.required' => 'El proyecto/servicio es obligatorio.',
            'proyecto_servicio.min' => 'El proyecto/servicio debe tener al menos 3 caracteres.',
            'proyecto_servicio.max' => 'El proyecto/servicio no puede exceder 255 caracteres.',
            'descripcion.max' => 'La descripción no puede exceder 1000 caracteres.',
            'valor.required' => 'El valor del contrato es obligatorio.',
            'valor.numeric' => 'El valor debe ser un número válido.',
            'valor.min' => 'El valor debe ser mayor a 0.',
            'valor.max' => 'El valor no puede exceder 999,999,999.',
            'fecha_emision.required' => 'La fecha de emisión es obligatoria.',
            'fecha_emision.date' => 'La fecha de emisión debe ser una fecha válida.',
            'fecha_emision.before_or_equal' => 'La fecha de emisión no puede ser futura.',
            'estado.required' => 'Debe seleccionar un estado.',
            'estado.in' => 'El estado seleccionado no es válido.',
            'ruta_archivo.file' => 'Debe seleccionar un archivo válido.',
            'ruta_archivo.mimes' => 'El archivo debe ser de tipo: PDF, DOC, DOCX, JPG, JPEG o PNG.',
            'ruta_archivo.max' => 'El archivo no puede exceder 10MB.'
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'user_id' => 'proveedor',
            'proyecto_servicio' => 'proyecto/servicio',
            'descripcion' => 'descripción',
            'valor' => 'valor',
            'fecha_emision' => 'fecha de emisión',
            'estado' => 'estado',
            'ruta_archivo' => 'archivo'
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Limpiar el valor para eliminar comas y espacios
        if ($this->has('valor')) {
            $valor = str_replace([',', ' ', '$'], '', $this->valor);
            $this->merge([
                'valor' => $valor
            ]);
        }

        // Asegurar que la fecha esté en formato correcto
        if ($this->has('fecha_emision') && $this->fecha_emision) {
            $this->merge([
                'fecha_emision' => date('Y-m-d', strtotime($this->fecha_emision))
            ]);
        }
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            // Validación adicional: el proveedor debe tener rol de contratista
            if ($this->user_id) {
                $user = \App\Models\User::find($this->user_id);
                if ($user && !$user->hasRole('contratista')) {
                    $validator->errors()->add('user_id', 'El usuario seleccionado no es un contratista válido.');
                }
            }

            // Validación adicional: no permitir duplicados en ciertos casos
            if ($this->proyecto_servicio && $this->user_id) {
                $query = CuentaCobro::where('proyecto_servicio', $this->proyecto_servicio)
                    ->where('user_id', $this->user_id)
                    ->where('estado', '!=', CuentaCobro::ESTADO_RECHAZADO);

                // Excluir el registro actual en caso de edición
                if ($this->route('id')) {
                    $query->where('id', '!=', $this->route('id'));
                }

                if ($query->exists()) {
                    $validator->errors()->add('proyecto_servicio', 'Ya existe un contrato activo con este proyecto/servicio para el proveedor seleccionado.');
                }
            }
        });
    }
}
