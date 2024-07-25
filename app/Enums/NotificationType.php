<?php

namespace App\Enums;

enum NotificationType: string {
    case Like = 'like';
    case Reply = 'reply';
    case Follow = 'follow';
}
