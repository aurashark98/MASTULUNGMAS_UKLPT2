<?php

namespace App\Notifications;

use App\Models\TaskBid;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BidAcceptedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $bid;

    public function __construct(TaskBid $bid)
    {
        $this->bid = $bid;
    }

    public function via($notifiable): array
    {
        $settings = $notifiable->getNotificationSetting('bid_accepted');
        $channels = [];
        if ($settings->database_enabled) $channels[] = 'database';
        if ($settings->email_enabled) $channels[] = 'mail';
        return $channels;
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Selamat! Penawaran Anda Diterima: ' . $this->bid->task->title)
            ->greeting('Halo, ' . $notifiable->name . '!')
            ->line('Kabar gembira! Pengguna telah menerima penawaran Anda untuk tugas: ' . $this->bid->task->title)
            ->line('Silakan mulai mengerjakan tugas tersebut setelah status berubah menjadi "Assigned".')
            ->action('Lihat Detail Tugas', route('tasks.show', $this->bid->task_id))
            ->line('Terima kasih telah bekerja sama dengan Mas Tulung Mas!');
    }

    public function toArray($notifiable): array
    {
        return [
            'task_id' => $this->bid->task_id,
            'task_title' => $this->bid->task->title,
            'message' => 'Penawaran Anda untuk "' . $this->bid->task->title . '" telah diterima!',
        ];
    }
}
