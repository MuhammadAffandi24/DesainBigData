<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;

class GenericNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /** @var string */
    protected $type;

    /** @var array */
    protected $data;

    public function __construct(string $type, array $data = [])
    {
        $this->type = $type;
        $this->data = $data;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    /**
     * Store the notification in the database.
     */
    public function toDatabase($notifiable)
    {
        return [
            'type' => $this->type,
            'data' => $this->data,
            'message' => $this->data['message'] ?? null,
        ];
    }

    /**
     * Broadcast representation.
     */
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage($this->toDatabase($notifiable));
    }

    /**
     * Array representation.
     */
    public function toArray($notifiable)
    {
        return $this->toDatabase($notifiable);
    }
}
