<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\NexmoMessage;

class NewFollowerNotification extends Notification
{
    public $follower;
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $follower)
    {
        $this->follower = $follower;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [
            'mail',
            'database',
            // 'nexmo',
            'broadcast',

        ];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject("New Follower")
            ->greeting("Hi " . $notifiable->name)
            ->line($this->follower->name . 'has followed you')
            ->action('Notification Action', url(route('profile.index', $this->follower->username)))
            ->line('Thank you for using our application!');
    }
    public function toDatabase($notifiable)
    {
        return [
            "title" => "New Follower",
            "body" => sprintf("%s has followed you", $this->follower->name),
            "action" => url(route('profile.index', $this->follower->username)),
            "image" => $this->follower->profile->avatar_url
        ];
    }
    public function toNexmo($notifiable)
    {
        $message = new NexmoMessage();
        $message->content(sprintf("%s has followed you", $this->follower->name));
        return $message;
    }
    public function toBroadcast($notifiable)
    {
        /*
        $message = new BroadcastMessage([
            "title" => "New Follower",
            "body" => sprintf("%s has followed you", $this->follower->name),
            "action" => url(route('profile.index', $this->follower->username)),
            //"user" => $this->follower
        ]);*/
        return [
            "title" => "New Follower",
            "body" => sprintf("%s has followed you", $this->follower->name),
            "action" => url(route('profile.index', $this->follower->username)),
            "user" => $this->follower
        ];
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
