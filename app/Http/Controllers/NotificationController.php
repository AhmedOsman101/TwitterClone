<?php

namespace App\Http\Controllers;

use App\Http\Resources\NotificationResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller {

  public function index(Request $request): JsonResponse {

    $user = $request->user();

    $allNotifications = NotificationResource::collection($user->notifications)->resolve();
    $unreadNotifications = NotificationResource::collection($user->unreadNotifications)->resolve();

    // Extract the IDs from the notifications
    $allNotificationIds = array_column($allNotifications, 'id');
    $unreadNotificationIds = array_column($unreadNotifications, 'id');

    // Find the IDs that are in $allNotifications but not in $unreadNotifications
    $readNotificationIds = array_diff($allNotificationIds, $unreadNotificationIds);

    // Filter the $allNotifications array to get only the read notifications
    $readNotifications = array_filter($allNotifications, function ($notification) use ($readNotificationIds) {
      return in_array($notification['id'], $readNotificationIds, true);
    });

    return response()->json([
      'all' => $allNotifications,
      'unread' => $unreadNotifications,
      'read' => $readNotifications,
    ]);
  }

  public function update(Request $request): void {
    $notification = $this->show($request);

    $notification->markAsRead();
  }

  public function destroy(Request $request): void {
    $notification = $this->show($request);

    $notification->delete();
  }

  private function show(Request $request) {
    $notifications = $request->user()->notifications;

    $notificationIndex = array_search($request->id, array_column($notifications->toArray(), 'id'), true);

    return $notifications[$notificationIndex];
  }
}
