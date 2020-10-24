<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBreed extends FormRequest
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
        // Personally I think "nullable" isn't really a good idea unless there's a really good reason for it,
        // but since the POSTMAN collection contains empty strings (not omitted keys) for updates,
        // I've included it both here and in the database migration.
        return [
            'animal_type'       => 'sometimes|string|in:cat,dog',
            'name'              => 'sometimes|nullable|string',
            'temperament'       => 'sometimes|nullable|string',
            'alternative_names' => 'sometimes|nullable|string',
            'life_span'         => 'sometimes|nullable|string',
            // Could also be validated against country array/table.
            'origin'            => 'sometimes|nullable|string',
            // Could be a custom URL validator regex to filter for wiki urls only.
            'wikipedia_url'     => 'sometimes|nullable|url',
            // Could also be validated against country array/table.
            'country_code'      => 'sometimes|nullable|string|size:2',
            'description'       => 'sometimes|nullable|string',
            'favourite'         => 'sometimes|boolean',
            // I am specifically not allowing updates to created_at and updated_at timestamps as requested.
            // Explain to me why this would be wanted?
            // I always treat them as fields indicating record changes within the system, not user updatable fields.
        ];
    }
}
