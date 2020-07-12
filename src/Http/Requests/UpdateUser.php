<?php

namespace Itstructure\LaRbac\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UpdateUser
 *
 * @package Itstructure\LaRbac\Http\Requests
 *
 * @author Andrey Girnik <girnikandrey@gmail.com>
 */
class UpdateUser extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return !empty(config('rbac.routesMainPermission')) ? $this->user()->can(config('rbac.routesMainPermission')) : true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'roles' => 'required|array',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'required' => __('rbac::validation.required'),
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'roles' => __('rbac::roles.roles')
        ];
    }
}
