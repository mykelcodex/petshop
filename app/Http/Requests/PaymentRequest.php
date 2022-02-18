<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
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
					'user_id'=>'required | exists:users,id',
          'type'=>'required | in:credit_card,cash_on_delivery,bank_transfer',
					'details'=>'required | array',
					'details.holder_name'=>'required_if:type,credit_card',
					'details.number'=>'required_if:type,credit_card',
					'details.ccv'=>'required_if:type,credit_card',
					'details.expire_date'=>'required_if:type,credit_card',
					'details.first_name'=>'required_if:type,cash_on_delivery',
					'details.last_name'=>'required_if:type,cash_on_delivery',
					'details.address'=>'required_if:type,cash_on_delivery',
					'details.swift'=>'required_if:type,bank_transfer',
					'details.iban'=>'required_if:type,bank_transfer',
					'details.name'=>'required_if:type,bank_transfer',
					
        ];
    }
}
