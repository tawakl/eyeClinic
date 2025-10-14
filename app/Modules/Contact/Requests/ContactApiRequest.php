<?php


namespace App\Modules\Contact\Requests;

use App\Modules\BaseApp\Api\Requests\BaseApiParserRequest;

class ContactApiRequest extends BaseApiParserRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'attributes.first_name' => 'required|min:3|max:191',
            'attributes.last_name' => 'required|min:3|max:191',
            'attributes.email' => 'required|email',
            'attributes.message' => 'required|min:3',
            'attributes.mobile' => ['required', 'regex:/^(05+[^2])+([0-9]){7}+$/'],
        ];
    }
}
