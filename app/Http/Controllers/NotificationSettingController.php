<?php

namespace App\Http\Controllers;

use App\Models\NotificationSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationSettingController extends Controller
{
    /**
     * Update notification settings for the user.
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $types = NotificationSetting::availableTypes();

        foreach ($types as $key => $label) {
            $user->notificationSettings()->updateOrCreate(
                ['type' => $key],
                [
                    'email_enabled' => $request->has("notif_{$key}_email"),
                    'database_enabled' => $request->has("notif_{$key}_db"),
                ]
            );
        }

        return back()->with('success', 'Pengaturan notifikasi berhasil diperbarui.');
    }
}
