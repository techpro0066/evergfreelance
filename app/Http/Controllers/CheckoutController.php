<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BuyCourse;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []);
        foreach($cart as $item){
            $buyCourse = new BuyCourse();

            $buyCourse->user_id = Auth::user()->id;
            $buyCourse->course_id = $item['id'];
            $buyCourse->status = 'active';
            $buyCourse->save();
        }
        session()->forget('cart');
        return response()->json(['success' => true, 'message' => 'Checkout successful']);
    }
}
