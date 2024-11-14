<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado a realizar esta solicitud.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Cambia esto si deseas restringir el acceso a ciertos usuarios
    }

    /**
     * Obtiene las reglas de validación que se aplicarán a la solicitud.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'content' => 'required|string|max:1000', // Asegura que el contenido sea obligatorio, una cadena, y no exceda los 1000 caracteres
        ];
    }

    /**
     * Personalizar los mensajes de error.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'content.required' => 'El contenido del comentario es obligatorio.',
            'content.string' => 'El comentario debe ser una cadena de texto.',
            'content.max' => 'El comentario no puede exceder los 1000 caracteres.',
        ];
    }
}
