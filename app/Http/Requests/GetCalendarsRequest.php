<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;

class GetCalendarsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
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
            'start'=>'required|date_format:Y-m-d H:i:s|after:now',
            'end'=>'required|date_format:Y-m-d H:i:s|after:start',
        ];
    }
    /**
     * @return string
     */
    public function getStart():string
    {
        return date('Y-m-d H:i:s',strtotime($this->get('start')));
    }

    /**
     * @return string
     */
    public function getEnd():string
    {
        return  date('Y-m-d H:i:s',strtotime($this->get('end')));
    }
}
