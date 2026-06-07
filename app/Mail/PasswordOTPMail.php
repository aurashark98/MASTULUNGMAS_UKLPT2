<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordOTPMail extends Mailable
{
    use Queueable, SerializesModels;

    public $otp;

    /**
     * Create a new message instance.
     */
    public function __construct($otp)
    {
        $this->otp = $otp;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Kode Verifikasi Perubahan Password MTM')
                    ->html("
                        <div style='font-family: Poppins, sans-serif; padding: 30px; max-width: 600px; margin: auto; border: 1px solid #e5e7eb; border-radius: 20px; background-color: #ffffff;'>
                            <div style='text-align: center; margin-bottom: 24px;'>
                                <h2 style='color: #ef4444; font-weight: 900; margin: 0; font-size: 24px; text-transform: uppercase; tracking-wider: 1px;'>Verifikasi Keamanan MTM</h2>
                            </div>
                            <hr style='border: none; border-top: 1px solid #f3f4f6; margin-bottom: 24px;'>
                            <p style='color: #4b5563; font-size: 15px; line-height: 1.6; margin-bottom: 24px;'>Halo,</p>
                            <p style='color: #4b5563; font-size: 15px; line-height: 1.6; margin-bottom: 24px;'>Kami menerima permintaan untuk mengubah kata sandi akun MTM Anda. Silakan gunakan kode verifikasi (OTP) berikut untuk menyelesaikan proses perubahan kata sandi:</p>
                            <div style='background: linear-gradient(135deg, #ef4444, #f59e0b); padding: 18px; border-radius: 16px; font-size: 32px; font-weight: 900; letter-spacing: 6px; text-align: center; color: #ffffff; margin: 30px 0; box-shadow: 0 10px 15px -3px rgba(239, 68, 68, 0.2);'>
                                {$this->otp}
                            </div>
                            <p style='color: #9ca3af; font-size: 13px; line-height: 1.6; margin-top: 24px;'>Kode verifikasi ini berlaku selama 10 menit. Demi keamanan akun Anda, jangan bagikan kode ini kepada siapa pun.</p>
                            <hr style='border: none; border-top: 1px solid #f3f4f6; margin: 24px 0;'>
                            <p style='color: #9ca3af; font-size: 12px; text-align: center; margin: 0;'>Pesan ini dikirim secara otomatis oleh sistem MTM. Jangan membalas email ini.</p>
                        </div>
                    ");
    }
}
