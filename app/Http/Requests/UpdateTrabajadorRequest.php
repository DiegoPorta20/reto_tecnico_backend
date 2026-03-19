<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpdateTrabajadorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('trabajador');

        return [
            'nombre'      => ['required', 'string', 'max:100'],
            'apellido'    => ['required', 'string', 'max:100'],
            'dni'         => ['required', 'string', 'max:20', Rule::unique('trabajadores', 'dni')->ignore($id)],
            'email'       => ['nullable', 'email', 'max:150', Rule::unique('trabajadores', 'email')->ignore($id)],
            'telefono'    => ['nullable', 'string', 'max:20'],
            'cargo_id'    => ['required', 'integer', 'exists:cargos,id'],
            'proyecto_id' => ['required', 'integer', 'exists:proyectos,id'],
            'activo'      => ['sometimes', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required'      => 'El nombre es obligatorio.',
            'apellido.required'    => 'El apellido es obligatorio.',
            'dni.required'         => 'El DNI es obligatorio.',
            'dni.unique'           => 'El DNI ya está en uso por otro trabajador.',
            'email.email'          => 'El correo electrónico no tiene un formato válido.',
            'email.unique'         => 'El correo electrónico ya está en uso por otro trabajador.',
            'cargo_id.required'    => 'El cargo es obligatorio.',
            'cargo_id.exists'      => 'El cargo seleccionado no existe.',
            'proyecto_id.required' => 'El proyecto es obligatorio.',
            'proyecto_id.exists'   => 'El proyecto seleccionado no existe.',
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'message' => 'Error de validación.',
                'errors'  => $validator->errors(),
            ], 422)
        );
    }
}
