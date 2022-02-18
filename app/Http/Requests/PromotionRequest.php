<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PromotionRequest extends FormRequest
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
          'title'=>'required',
					'content'=>'required',
					'metadata'=>'required',
					'metadata.valid_from'=>'required | date',
					'metadata.valid_to'=>'required | date',
					'metadata.image'=> 'required | exists:files,uuid'
        ];
    }
}
