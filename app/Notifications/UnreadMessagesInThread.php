<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class UnreadMessagesInThread extends Notification
{
    use Queueable;

    protected $messages;

    protected $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($messages, $user)
    {
        $this->messages = $messages;
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        if (isset($this->messages)) {
            if (count($this->messages->toArray()) == 0){
                return [];
            }
        }

        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)->markdown('emails.thread-unread-messages',[
            'messages' => $this->messages,
            'user' => $this->user
        ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
