<?php

namespace App\Http\Requests\Admin\Discount;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
class StoreDiscount extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.discount.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            "amount" => ['max:100','min:0.0','numeric','required'],
            "type" => ['required'],
            'item_id' => ['nullable'],
            'category_id' => ['nullable'],
        ];
    }

    /**
    * Modify input data
    *
    * @return array
    */
    public function getSanitized(): array
    {
        $sanitized = $this->validated();


        if($sanitized['type']['name']=='item'){
            if($this->getItemId()==null){
                $validator = Validator::make([], []);
                // Manually set errors
                $validator->errors()->add('item_id', "The item field is required");
                $errorResponse = response()->json(["message"=>"The item field is required","errors"=>["item_id"=>["The item field is required"]]], 422);
                throw new ValidationException($validator, $errorResponse);
            }


         }else if($sanitized['type']['name']=='category'){
            if($this->getCategoryId()==null){
                $validator = Validator::make([], []);
                // Manually set errors
                $validator->errors()->add('category_id', "The category field is required");
                $errorResponse = response()->json(["message"=>"The category field is required","errors"=>["category_id"=>["The category field is required"]]], 422);
                throw new ValidationException($validator, $errorResponse);
            }
         }



        //Add your code for manipulation with request data here

        return $sanitized;
    }

    public function getCategoryId(){

        if (isset( $this->category_id)){
            return $this->get('category_id')['id'];
        }
        return null;
    }
    public function getItemId(){
        if (isset( $this->item_id)){
            return $this->get('item_id')['id'];
        }
        return null;
    }
    public function getType(){
        if (isset( $this->type)){
            return $this->type['name'];
        }
        return null;
    }



}
