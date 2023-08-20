<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Address;
use App\Models\Order;
use App\Models\Wishlist;
use App\Traits\ShippingTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    use ShippingTrait;

    public function home()
    {
        $orders = Order::where('user_id', Auth::id())->count();

        return view('dashboard.home', compact('orders'));
    }

    public function myWishlist()
    {
        $wishes = Wishlist::with('products')->where('user', Auth::user()->slug)->simplePaginate(12);

        return view('dashboard.wishlist', compact('wishes'));

    }

    public function myOrders()
    {
        $orders = Order::where('user_id', Auth::id())->simplePaginate(12);

        return view('dashboard.orders', compact('orders'));

    }

    public function myOrderDetails($slug)
    {
        $order = Order::where('order_number', $slug)->firstOrfail();
        
        return view('dashboard.order-details', compact('order'));

    }


    public function myAddress()
    {
        $addresses = Address::where('user_id', Auth::id())->orderBy('default', 'desc')->get();
        
        return view('dashboard.address', compact('addresses'));

    }

    public function createAddress()
    {

        return view('dashboard.create-address');

    }

    public function saveAddress(CheckoutRequest $request)
    {

        $this->createSameAddress($request);

        \Session::flash('success', 'Address saved successfully');

        return redirect()->route('address');

    }

    public function editAddress($slug)
    {
        $address = Address::where('slug', $slug)->firstOrfail();
        
        return view('dashboard.edit-address', compact('address'));

    }

    public function updateAddress(CheckoutRequest $request){

        $address = $this->createSameAddress($request);

        \Session::flash('success', 'Address saved successfully');

        return redirect()->route('address');
    }


    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('dashboard.account', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('success', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current-password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
