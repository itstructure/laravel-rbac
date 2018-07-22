<?php
namespace Itstructure\LaRbac\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class UpdatePermission
 *
 * @package Itstructure\LaRbac\Http\Requests
 * @author Andrey Girnik <girnikandrey@gmail.com>
 */
class UpdatePermission extends FormRequest
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
        $id = $this->route('permission')->id;
        return [
            'name' => [
                'required',
                'string',
                'min:3',
                'max:191',
                Rule::unique('permissions')->where('id', '<>', $id),
            ],
            'description' => [
                'required',
                'string',
                'min:3',
                'max:191',
                Rule::unique('permissions')->where('id', '<>', $id),
            ],
        ];
    }
}
