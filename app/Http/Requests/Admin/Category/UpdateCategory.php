<?php

namespace App\Http\Requests\Admin\Category;

use Brackets\Translatable\TranslatableFormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UpdateCategory extends TranslatableFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.category.edit', $this->category);
    }

/**
     * Get the validation rules that apply to the requests untranslatable fields.
     *
     * @return array
     */
    public function untranslatableRules(): array {
        return [
            'name' => ['sometimes', 'string'],
            'description' => ['nullable', 'string'],
            'parent_id' => ['nullable'],



        ];
    }

    /**
     * Get the validation rules that apply to the requests translatable fields.
     *
     * @return array
     */
    public function translatableRules($locale): array {
        return [
          

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
        if($this->getParentId()!=null){
            $parentCategory= Category::find($this->getParentId());
            if(count($parentCategory->hierarchicalPath())>=3){
             $validator = Validator::make([], []);
             // Manually set errors
             $validator->errors()->add('parent_id', "you can't put more than 4 subcatgories");
             $errorResponse = response()->json(["message"=>"you can't put more than 4 subcatgories","errors"=>["parent_id"=>["you can't put more than 4 subcatgories"]]], 422);
             throw new ValidationException($validator, $errorResponse);
         }
        }


        //Add your code for manipulation with request data here

        return $sanitized;
    }
    public function getParentId(){
        if ($this->has('parent_id')){
            if(isset($this->get('parent_id')['id'])){
                return $this->get('parent_id')['id'];
            }else{
                return $this->get('parent_id');
            }
        }
        return null;
    }
}
