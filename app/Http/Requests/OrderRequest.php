<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
					'order_status_id'=>'required | integer|exists:order_statuses,id',
					'payment_id'=>'required | integer | exists:payments,id',
					'products'=>'required | array',
					'address'=>'required | array',
					'address.billing'=>'required',
					'address.shipping'=>'required',
					'amount'=> 'required',
					'user_id'=>"required | exists:users,id",
					'products.*.id'=>'required | exists:products,id',
					'products.*.quantity'=>'required | integer'
        ];
    }
}
