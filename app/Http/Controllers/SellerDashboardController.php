<?php

namespace App\Http\Controllers;

use App\Notifications\LowStockAlertNotification;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SellerDashboardController extends Controller
{
    public function index(Request $request): View
    {
        $seller = $request->user();
        $editingProduct = null;

        if ($request->filled('edit')) {
            $editingProduct = $seller->products()->find($request->integer('edit'));
        }

        $products = $seller->products()->latest()->paginate(10)->withQueryString();
        $orders = Order::query()
            ->with([
                'buyer:id,name,email',
                'items' => fn($query) => $query
                    ->where('seller_id', $seller->id)
                    ->with('product:id,name,image_path'),
            ])
            ->whereNotNull('ordered_at')
            ->whereHas('items', fn($query) => $query->where('seller_id', $seller->id))
            ->latest('ordered_at')
            ->get();

        return view('seller-dashboard', [
            'editingProduct' => $editingProduct,
            'products' => $products,
            'orders' => $orders,
            'categories' => \App\Models\Category::where('is_active', true)->get(),
            'lowStockProducts' => $seller->products()
                ->with('category')
                ->whereColumn('stock', '<=', 'minimum_stock')
                ->latest()
                ->get(),
            'lowStockNotifications' => $seller->notifications()
                ->where('type', LowStockAlertNotification::class)
                ->latest()
                ->limit(5)
                ->get(),
            'unreadLowStockNotifications' => $seller->unreadNotifications()
                ->where('type', LowStockAlertNotification::class)
                ->count(),
            'stats' => [
                'active_products' => $seller->products()->where('is_active', true)->count(),
                'pending_order_items' => OrderItem::query()
                    ->whereHas('order', fn($query) => $query->whereNotNull('ordered_at'))
                    ->where('seller_id', $seller->id)
                    ->where('status', 'pending')
                    ->count(),
                'inventory_value' => (float) $seller->products()
                    ->selectRaw('COALESCE(SUM((price - (price * discount / 100)) * stock), 0) as total')
                    ->value('total'),
                'accepted_revenue' => (float) OrderItem::query()
                    ->whereHas('order', fn($query) => $query->whereNotNull('ordered_at'))
                    ->where('seller_id', $seller->id)
                    ->whereIn('status', [
                        OrderItem::STATUS_ACCEPTED,
                        OrderItem::STATUS_PREPARING,
                        OrderItem::STATUS_SHIPPING,
                        OrderItem::STATUS_DELIVERED,
                    ])
                    ->selectRaw('COALESCE(SUM(unit_price * quantity), 0) as total')
                    ->value('total'),
            ],
        ]);
    }

    public function profile(Request $request): View
    {
        return view('seller.profile', [
            'user' => $request->user(),
        ]);
    }

    public function profileUpdate(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'shop_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->shop_name = $validated['shop_name'];
        $user->phone = $validated['phone'];
        $user->country = $validated['country'];
        $user->city = $validated['city'];
        $user->postal_code = $validated['postal_code'];
        $user->address = $validated['address'];

        // Handle Photo Upload (Saving by ID to avoid DB column)
        if ($request->hasFile('profile_photo')) {
            $request->validate(['profile_photo' => 'image|max:2048']);
            $extension = $request->file('profile_photo')->getClientOriginalExtension();
            $request->file('profile_photo')->storeAs('avatars', $user->id . '.' . $extension, 'public');
        }

        if (!empty($validated['password'])) {
            $user->password = \Illuminate\Support\Facades\Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    public function setting(Request $request): View
    {
        return view('seller.setting', [
            'user' => $request->user(),
        ]);
    }

    public function help(Request $request): View
    {
        return view('seller.help', [
            'user' => $request->user(),
        ]);
    }

    public function sales(Request $request): View
    {
        $seller = $request->user();
        $orders = Order::query()
            ->with([
                'buyer:id,name,email',
                'items' => fn($query) => $query
                    ->where('seller_id', $seller->id)
                    ->with('product:id,name,image_path'),
            ])
            ->whereNotNull('ordered_at')
            ->whereHas('items', fn($query) => $query->where('seller_id', $seller->id))
            ->latest('ordered_at')
            ->get();

        return view('seller.sales', [
            'user' => $seller,
            'orders' => $orders,
        ]);
    }

    public function markNotificationAsRead(Request $request, DatabaseNotification $notification)
    {
        if (
            $notification->notifiable_id !== $request->user()->id
            || $notification->notifiable_type !== get_class($request->user())
        ) {
            abort(403);
        }

        $notification->markAsRead();

        return redirect()->back()->with('success', 'Notification marked as read.');
    }

    public function destroyAccount(Request $request)
    {
        $user = $request->user();

        // Logout first
        \Illuminate\Support\Facades\Auth::logout();

        // Delete user
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Account deleted successfully.');
    }
}
