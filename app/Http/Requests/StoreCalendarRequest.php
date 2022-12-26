<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCalendarRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title'=>'required|string|max:255',
            'description'=>'nullable|string',
            'start'=>'required|date_format:Y-m-d H:i:s|after:now',
            'duration'=>'required|integer|min:0|not_in:0',
        ];
    }

    /**
     * @return string
     */
    public function getTitle():string
    {
        return $this->get('title');
    }

    /**
     * @return string|null
     */
    public function getDescription():string|null
    {
        return $this->get('description')?? null;
    }

    /**
     * @return int
     */
    public function getDuration():int
    {
        return $this->get('duration');
    }
    /**
     * @return string
     */
    public function getStart():string
    {
        return $this->get('start');
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->route()->parameter('id');
    }
}
