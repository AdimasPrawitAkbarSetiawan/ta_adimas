<?php

namespace App\Helpers;

use App\Models\NotificationApp;

class NotificationHelper
{
    public static function send($userId, $title, $message, $type = null)
    {
        NotificationApp::create([
            'user_id' => $userId,
            'title'   => $title,
            'message' => $message,
            'type'    => $type,
            'is_read' => false,
        ]);
    }

    public static function sendToAll($userIds, $title, $message, $type = null)
    {
        foreach ($userIds as $userId) {
            self::send($userId, $title, $message, $type);
        }
    }
}