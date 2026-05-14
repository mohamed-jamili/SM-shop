<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Support\SessionCart;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class BuyerDashboardController extends Controller
{
    // Show the main marketplace dashboard for buyers
    public function index(Request $request): View
    {
        $finalPriceExpression = '(price - (price * discount / 100))';

        // 1. Start a query for active products with stock
        $query = Product::query()
            ->with(['seller', 'category']) // Eager load relationships to save database hits
            ->where('is_active', true)
            ->where('stock', '>', 0);

        // 2. Apply search filter if user typed something
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // 3. Apply category filter if selected
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // 4. Apply price filters
        if ($request->filled('min_price')) {
            $query->whereRaw("{$finalPriceExpression} >= ?", [$request->min_price]);
        }
        if ($request->filled('max_price')) {
            $query->whereRaw("{$finalPriceExpression} <= ?", [$request->max_price]);
        }

        // 5. Apply sorting logic
        $sort = $request->get('sort', 'latest');
        if ($sort === 'price_asc') {
            $query->orderByRaw("{$finalPriceExpression} asc");
        } elseif ($sort === 'price_desc') {
            $query->orderByRaw("{$finalPriceExpression} desc");
        } else {
            $query->latest(); // Default: Newest first
        }

        // 6. Execute query with pagination (12 items per page)
        $products = $query->paginate(12)->withQueryString();

        // 7. Get buyer's order history (only if logged in)
        $user = auth()->user();
        $orders = $user
            ? $user->orders()
                ->whereNotNull('ordered_at')
                ->with('items.product')
                ->latest('ordered_at')
                ->get()
            : collect();

        // 8. Return the view with all necessary data
        return view('buyer-dashboard', [
            'products' => $products,
            'orders' => $orders,
            'categories' => Category::where('is_active', true)->get(),
            'cartCount' => SessionCart::count(),
            'cartItems' => SessionCart::items(),
            'cartTotal' => SessionCart::total(),
            'activeTab' => $request->get('tab', 'products'),
            'aiFilterReady' => true,
        ]);
    }

    public function profileUpdate(Request $request): RedirectResponse
    {
        $user = $request->user();

        $data = array_merge([
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'address' => $user->address,
            'city' => $user->city,
            'postal_code' => $user->postal_code,
            'country' => $user->country,
        ], $request->all());

        $validated = Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:100'],
            'postal_code' => ['nullable', 'string', 'max:20'],
            'country' => ['nullable', 'string', 'max:100'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'profile_image' => ['nullable', 'image', 'max:2048'],
        ])->validate();

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'] ?? $user->phone;
        $user->address = $validated['address'] ?? $user->address;
        $user->city = $validated['city'] ?? $user->city;
        $user->postal_code = $validated['postal_code'] ?? $user->postal_code;
        $user->country = $validated['country'] ?? $user->country;

        if ($request->hasFile('profile_image')) {
            $extension = $request->file('profile_image')->getClientOriginalExtension();
            $request->file('profile_image')->storeAs('avatars', $user->id . '.' . $extension, 'public');
        }

        if (! empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()
            ->route('buyer.home', ['tab' => 'profile'])
            ->with('success', 'Profile updated successfully!');
    }

    public function destroyAccount(Request $request): RedirectResponse
    {
        $user = $request->user();

        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Account deleted successfully.');
    }
}
