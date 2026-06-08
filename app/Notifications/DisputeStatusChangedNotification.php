<?php

namespace App\Notifications;

use App\Models\TaskDispute;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DisputeStatusChangedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $dispute;

    public function __construct(TaskDispute $dispute)
    {
        $this->dispute = $dispute;
    }

    public function via($notifiable): array
    {
        $settings = $notifiable->getNotificationSetting('dispute_status_changed');
        $channels = [];
        if ($settings->database_enabled) $channels[] = 'database';
        if ($settings->email_enabled) $channels[] = 'mail';
        return $channels;
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Update Status Laporan: ' . $this->dispute->task->title)
            ->greeting('Halo, ' . $notifiable->name . '!')
            ->line('Status laporan masalah Anda untuk tugas "' . $this->dispute->task->title . '" telah diperbarui menjadi: ' . ucfirst($this->dispute->status))
            ->action('Lihat Detail Laporan', route('disputes.show', $this->dispute->id))
            ->line('Terima kasih telah menggunakan layanan kami.');
    }

    public function toArray($notifiable): array
    {
        return [
            'dispute_id' => $this->dispute->id,
            'status' => $this->dispute->status,
            'message' => 'Status laporan masalah untuk "' . $this->dispute->task->title . '" diubah menjadi ' . $this->dispute->status . '.',
        ];
    }
}
