<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;

class StockLowNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $product;
    protected $stock;

    public function __construct($product, $stock)
    {
        $this->product = $product;
        $this->stock = $stock;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'type' => 'stock.low',
            'product_id' => $this->product->id,
            'product_name' => $this->product->name,
            'stock' => $this->stock,
            'message' => "{$this->product->name} sisa {$this->stock} pcs",
            'action_url' => route('daftar.belanja.index')
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage($this->toDatabase($notifiable));
    }
}