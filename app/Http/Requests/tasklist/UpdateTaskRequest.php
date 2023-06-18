<?php

namespace App\Http\Requests\tasklist;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
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
            'id'          => 'required|numeric|exists:tasks,id',
            'title'       => 'required|String',
            'description' => 'required|string',
            'due_date'    => 'nullable|required|date',
            'status'      => 'nullable|boolean',
        ];
    }

    public function messages()
    {
        return [
            'title.required'       => 'Please add a valid Title',
            'description.required' => 'Please add a valid Description',
            'due_date.required'    => 'Please select Date',
        ];
    }

}
