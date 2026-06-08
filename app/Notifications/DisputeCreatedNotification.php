<?php

namespace App\Notifications;

use App\Models\TaskDispute;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DisputeCreatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $dispute;

    public function __construct(TaskDispute $dispute)
    {
        $this->dispute = $dispute;
    }

    public function via($notifiable): array
    {
        $settings = $notifiable->getNotificationSetting('dispute_created');
        $channels = [];
        if ($settings->database_enabled) $channels[] = 'database';
        if ($settings->email_enabled) $channels[] = 'mail';
        return $channels;
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Laporan Masalah Baru: ' . $this->dispute->task->title)
            ->greeting('Halo, ' . $notifiable->name . '!')
            ->line('Ada laporan masalah baru terkait tugas: ' . $this->dispute->task->title)
            ->line('Alasan: ' . $this->dispute->reason)
            ->action('Lihat Detail Laporan', route('disputes.show', $this->dispute->id))
            ->line('Tim admin kami akan segera meninjau laporan ini.');
    }

    public function toArray($notifiable): array
    {
        return [
            'dispute_id' => $this->dispute->id,
            'task_id' => $this->dispute->task_id,
            'task_title' => $this->dispute->task->title,
            'message' => 'Laporan masalah baru untuk tugas "' . $this->dispute->task->title . '" telah dibuat.',
        ];
    }
}
