<?php

namespace App\Notifications;

use App\Models\TaskBid;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewBidNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $bid;

    public function __construct(TaskBid $bid)
    {
        $this->bid = $bid;
    }

    public function via($notifiable): array
    {
        $settings = $notifiable->getNotificationSetting('new_bid');
        $channels = [];
        if ($settings->database_enabled) $channels[] = 'database';
        if ($settings->email_enabled) $channels[] = 'mail';
        return $channels;
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Penawaran Baru untuk Tugas Anda: ' . $this->bid->task->title)
            ->greeting('Halo, ' . $notifiable->name . '!')
            ->line('Anda telah menerima penawaran baru dari ' . $this->bid->mitra->name . '.')
            ->line('Jumlah Penawaran: Rp ' . number_format($this->bid->bid_amount, 0, ',', '.'))
            ->line('Pesan: "' . $this->bid->message . '"')
            ->action('Lihat Penawaran', route('tasks.show', $this->bid->task_id))
            ->line('Terima kasih telah menggunakan Mas Tulung Mas!');
    }

    public function toArray($notifiable): array
    {
        return [
            'task_id' => $this->bid->task_id,
            'task_title' => $this->bid->task->title,
            'mitra_name' => $this->bid->mitra->name,
            'bid_amount' => $this->bid->bid_amount,
            'message' => 'Penawaran baru diterima untuk tugas: ' . $this->bid->task->title,
        ];
    }
}
