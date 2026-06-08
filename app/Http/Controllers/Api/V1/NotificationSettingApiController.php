<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationSettingApiController extends Controller
{
    private array $settingTypes = [
        'new_bid', 'bid_accepted', 'task_started', 'task_completed',
        'payment_received', 'new_review', 'dispute_created',
    ];

    /**
     * GET /api/v1/notification-settings
     * Get all notification settings for the authenticated user.
     */
    public function show(Request $request)
    {
        $user     = $request->user();
        $settings = [];

        foreach ($this->settingTypes as $type) {
            $setting    = $user->getNotificationSetting($type);
            $settings[] = [
                'type'             => $type,
                'email_enabled'    => (bool) $setting->email_enabled,
                'database_enabled' => (bool) $setting->database_enabled,
            ];
        }

        return response()->json([
            'success' => true,
            'data'    => $settings,
        ]);
    }

    /**
     * PUT /api/v1/notification-settings
     * Update notification settings.
     * Body: { "settings": [{ "type": "new_bid", "email_enabled": true, "database_enabled": false }] }
     */
    public function update(Request $request)
    {
        $request->validate([
            'settings'                     => 'required|array',
            'settings.*.type'              => 'required|string|in:' . implode(',', $this->settingTypes),
            'settings.*.email_enabled'     => 'required|boolean',
            'settings.*.database_enabled'  => 'required|boolean',
        ]);

        $user = $request->user();

        foreach ($request->settings as $item) {
            $user->notificationSettings()->updateOrCreate(
                ['type' => $item['type']],
                [
                    'email_enabled'    => $item['email_enabled'],
                    'database_enabled' => $item['database_enabled'],
                ]
            );
        }

        return response()->json([
            'success' => true,
            'message' => 'Pengaturan notifikasi berhasil diperbarui.',
        ]);
    }
}
