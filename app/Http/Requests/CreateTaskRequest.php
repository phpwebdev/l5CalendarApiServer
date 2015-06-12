<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateTaskRequest extends Request {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'location'    => 'required',
            'description' => 'required',
            'title'       => 'required',
            'color_id'    => 'required',
            'category_id' => 'required',
            'start_at'    => 'required|date',
            'end_at'      => 'required|date|after:start_at',
        ];
    }

    /**
     * Get the proper failed validation response for the request.
     *
     * @param  array  $errors
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function response(array $errors) {
        return response()->json(['errors' => $errors, "code" => 422], 422);
    }
}
