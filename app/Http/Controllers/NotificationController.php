<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller {
  public function update (Request $request): void {
    $notifications = $request->user()->notifications;

    $notificationIndex = array_search($request->id, array_column($notifications->toArray(), 'id'), true);

    $notification = $notifications[$notificationIndex];

    $notification->markAsRead();
  }

  public function destroy (Request $request): void {
    $notifications = $request->user()->notifications;

    $notificationIndex = array_search($request->id, array_column($notifications->toArray(), 'id'), true);

    $notification = $notifications[$notificationIndex];

    $notification->delete();
  }
}
