<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateColorRequest extends Request {
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
            'name'     => 'required',
            'hex_code' => ['required', 'xdigit', 'min:6', 'max:6'],
        ];
    }

    public function response(array $errors) {
        return response()->json(['errors' => $errors, "code" => 422], 422);
    }
}
