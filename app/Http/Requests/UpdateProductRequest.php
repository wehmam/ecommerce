<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "category_id"       => "required",
            "title"             => "required",
            "qty"               => "required",
            "price"             => "required",
            "description"       => "required",
            "is_active"         => "required",
            "upload_image.*"    => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ];
    }
}
