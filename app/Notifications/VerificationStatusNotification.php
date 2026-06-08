<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VerificationStatusNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $isApproved;

    public function __construct(bool $isApproved)
    {
        $this->isApproved = $isApproved;
    }

    public function via($notifiable): array
    {
        $settings = $notifiable->getNotificationSetting('verification_status');
        $channels = [];
        if ($settings->database_enabled) $channels[] = 'database';
        if ($settings->email_enabled) $channels[] = 'mail';
        return $channels;
    }

    public function toMail($notifiable): MailMessage
    {
        $message = (new MailMessage)
            ->subject('Update Status Verifikasi Mitra - Mas Tulung Mas')
            ->greeting('Halo, ' . $notifiable->name . '!');

        if ($this->isApproved) {
            $message->line('Selamat! Pengajuan Anda sebagai Mitra di Mas Tulung Mas telah disetujui.')
                    ->line('Sekarang Anda dapat mulai memberikan penawaran pada tugas-tugas yang tersedia.')
                    ->action('Cari Tugas', route('dashboard'));
        } else {
            $message->line('Mohon maaf, pengajuan Anda sebagai Mitra belum dapat kami setujui saat ini.')
                    ->line('Pastikan data profil dan dokumen pendukung Anda sudah sesuai dengan ketentuan kami.')
                    ->action('Update Profil', route('profile.edit'));
        }

        return $message->line('Terima kasih atas partisipasi Anda!');
    }

    public function toArray($notifiable): array
    {
        return [
            'status' => $this->isApproved ? 'approved' : 'rejected',
            'message' => $this->isApproved 
                ? 'Selamat! Verifikasi mitra Anda telah disetujui.' 
                : 'Mohon maaf, verifikasi mitra Anda ditolak.',
        ];
    }
}
