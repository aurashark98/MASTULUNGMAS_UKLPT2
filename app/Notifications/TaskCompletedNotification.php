<?php

namespace App\Notifications;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskCompletedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function via($notifiable): array
    {
        $settings = $notifiable->getNotificationSetting('task_completed');
        $channels = [];
        if ($settings->database_enabled) $channels[] = 'database';
        if ($settings->email_enabled) $channels[] = 'mail';
        return $channels;
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Tugas Selesai: ' . $this->task->title)
            ->greeting('Halo, ' . $notifiable->name . '!')
            ->line('Mitra kami telah menyelesaikan tugas: ' . $this->task->title)
            ->line('Silakan periksa hasilnya dan berikan ulasan Anda.')
            ->action('Lihat Tugas & Beri Ulasan', route('tasks.show', $this->task->id))
            ->line('Terima kasih telah mempercayai Mas Tulung Mas!');
    }

    public function toArray($notifiable): array
    {
        return [
            'task_id' => $this->task->id,
            'task_title' => $this->task->title,
            'message' => 'Tugas "' . $this->task->title . '" telah selesai dikerjakan.',
        ];
    }
}
