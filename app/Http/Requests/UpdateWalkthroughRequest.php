<?php

namespace App\Http\Requests;

use App\Models\Walkthrough;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateWalkthroughRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('walkthrough_edit');
    }

    public function rules()
    {
        return [
            'page' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'title' => [
                'string',
                'nullable',
            ],
            'description' => [
                'string',
                'nullable',
            ],
        ];
    }
}
