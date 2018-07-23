<?php
namespace Itstructure\LaRbac\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class Delete
 *
 * @package Itstructure\LaRbac\Http\Requests
 * @author Andrey Girnik <girnikandrey@gmail.com>
 */
class Delete extends FormRequest
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
            'items' => 'required|array',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'items.required' => config('rbac.deleteRequired'),
        ];
    }
}
