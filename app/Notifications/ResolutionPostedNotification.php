<?php

namespace App\Notifications;

use App\Models\TaskDispute;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResolutionPostedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $dispute;

    public function __construct(TaskDispute $dispute)
    {
        $this->dispute = $dispute;
    }

    public function via($notifiable): array
    {
        $settings = $notifiable->getNotificationSetting('resolution_posted');
        $channels = [];
        if ($settings->database_enabled) $channels[] = 'database';
        if ($settings->email_enabled) $channels[] = 'mail';
        return $channels;
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Resolusi Laporan: ' . $this->dispute->task->title)
            ->greeting('Halo, ' . $notifiable->name . '!')
            ->line('Admin telah memberikan resolusi untuk laporan masalah pada tugas: ' . $this->dispute->task->title)
            ->line('Resolusi: ' . $this->dispute->resolution)
            ->action('Lihat Detail Resolusi', route('disputes.show', $this->dispute->id))
            ->line('Terima kasih telah menggunakan layanan kami.');
    }

    public function toArray($notifiable): array
    {
        return [
            'dispute_id' => $this->dispute->id,
            'message' => 'Admin telah memberikan resolusi untuk laporan "' . $this->dispute->task->title . '".',
        ];
    }
}
