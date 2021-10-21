<?php

namespace App\Http\Requests\AdvertCampaign;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdvertCampaignRequest extends FormRequest
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
            'name' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'total_budget' => 'required',
            'daily_budget' => 'required',
            'banner' => 'nullable|array|min:1',
            'banner.*' => 'image|mimes:jpeg,png,jpg',
        ];
    }
}
