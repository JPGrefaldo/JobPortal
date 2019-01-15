<?php

namespace App\Http\Requests;

use Cmgmyr\Messenger\Models\Message;
use Illuminate\Foundation\Http\FormRequest;

class StorePendingFlagMessageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $message = Message::find($this->input('message_id'));
        $recipients = $message->recipients;

        return auth()->user()->id !== $message->user->id
            && auth()->user()->id === $recipients->first()->user->id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'message_id' => 'required|exists:messages,id',
            'reason' => 'required|string'
        ];
    }

    protected function isMessageOfUser($message)
    {
        return auth()->user()->id !== $message->user->id;
    }
}
