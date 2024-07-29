<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller {
  public function update(Request $request): void {
    $notification = $this->getNotification($request);

    $notification->markAsRead();
  }

  public function destroy(Request $request): void {
    $notification = $this->getNotification($request);

    $notification->delete();
  }

  private function getNotification(Request $request) {
    $notifications = $request->user()->notifications;

    $notificationIndex = array_search($request->id, array_column($notifications->toArray(), 'id'), true);

    return $notifications[$notificationIndex];
  }
}
