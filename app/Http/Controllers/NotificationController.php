<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\View\View;

class NotificationController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        return view('notifications', [
            'notifications' => $user->notifications()->latest()->paginate(20),
            'unreadCount' => $user->unreadNotifications()->count(),
        ]);
    }

    public function summary(Request $request)
    {
        $user = $request->user();

        $recentNotifications = $user->notifications()
            ->latest()
            ->limit(5)
            ->get()
            ->map(function (DatabaseNotification $notification) {
                return [
                    'id' => $notification->id,
                    'title' => $notification->data['title'] ?? 'Notification',
                    'message' => $notification->data['message'] ?? '',
                    'read_at' => $notification->read_at ? $notification->read_at->toDateTimeString() : null,
                    'created_at' => $notification->created_at->diffForHumans(),
                    'order_id' => $notification->data['order_id'] ?? null,
                    'type' => $notification->type,
                ];
            });

        return response()->json([
            'unreadCount' => $user->unreadNotifications()->count(),
            'totalCount' => $user->notifications()->count(),
            'notifications' => $recentNotifications,
        ]);
    }

    public function markAsRead(Request $request, DatabaseNotification $notification): RedirectResponse
    {
        if (!$request->user()
            || $notification->notifiable_id !== $request->user()->id
            || $notification->notifiable_type !== get_class($request->user())) {
            abort(403);
        }

        $notification->markAsRead();

        return redirect()->back()->with('success', 'Notification marked as read.');
    }
}
