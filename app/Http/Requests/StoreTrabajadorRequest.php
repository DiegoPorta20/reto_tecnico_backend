<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreTrabajadorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre'      => ['required', 'string', 'max:100'],
            'apellido'    => ['required', 'string', 'max:100'],
            'dni'         => ['required', 'string', 'max:20', 'unique:trabajadores,dni'],
            'email'       => ['nullable', 'email', 'max:150', 'unique:trabajadores,email'],
            'telefono'    => ['nullable', 'string', 'max:20'],
            'cargo_id'    => ['required', 'integer', 'exists:cargos,id'],
            'proyecto_id' => ['required', 'integer', 'exists:proyectos,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required'      => 'El nombre es obligatorio.',
            'apellido.required'    => 'El apellido es obligatorio.',
            'dni.required'         => 'El DNI es obligatorio.',
            'dni.unique'           => 'El DNI ya está registrado.',
            'email.email'          => 'El correo electrónico no tiene un formato válido.',
            'email.unique'         => 'El correo electrónico ya está registrado.',
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
