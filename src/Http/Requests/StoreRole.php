<?php
namespace Itstructure\LaRbac\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class StoreRole
 *
 * @package Itstructure\LaRbac\Http\Requests
 * @author Andrey Girnik <girnikandrey@gmail.com>
 */
class StoreRole extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|min:3|max:191|unique:roles',
            'description' => 'required|string|min:3|max:191|unique:roles',
            'permissions' => 'required|array',
        ];
    }
}
