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

        return $this->requesterDoesntOwn($message)
            && $this->requesterIsRecipient($message);
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

    private function requesterDoesntOwn($message)
    {
        return auth()->user()->id !== $message->user->id;
    }

    private function requesterIsRecipient($message)
    {
        $recipients = $message->recipients;

        return auth()->user()->id === $recipients->first()->user->id;
    }
}
