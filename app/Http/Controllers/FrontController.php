<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;

class FrontController extends Controller
{
    public function courses(){
        $courses = Course::where('status', 'active')->get();
        $cart = session()->get('cart', []);
        return view('front.courses', get_defined_vars());
    }

    public function courseDetail($slug){
        $course = Course::where('slug', $slug)->first();
        $cart = session()->get('cart', []);
        return view('front.course-detail', get_defined_vars());
    }

    public function aboutUs(){
        return view('front.about-us');
    }

    public function faq(){
        return view('front.faq');
    }

    public function contact(){
        return view('front.contact');
    }

    public function addToCart(Request $request){
        $courseId = $request->course_id;
        $course = Course::find($courseId);
        $cart = session()->get('cart', []);
        if (!isset($cart[$courseId])) {
            $cart[$courseId] = [
                "id" => $course->id,
                "title" => $course->title,
                "price" => $course->price,
                "thumbnail" => $course->thumbnail,
                "quantity" => 1
            ];
        }
        else{
            return response()->json(['success' => false, 'message' => 'Course already in cart']);
        }
        session()->put('cart', $cart);
        return response()->json(['success' => true, 'message' => 'Course added to cart successfully', 'cartCount' => count($cart)]);
    }

    public function removeFromCart(Request $request){
        $courseId = $request->course_id;
        $cart = session()->get('cart', []);
        if (isset($cart[$courseId])) {
            unset($cart[$courseId]);
        }
        else{
            return response()->json(['success' => false, 'message' => 'Course not found in cart']);
        }
        session()->put('cart', $cart);
        return response()->json(['success' => true, 'message' => 'Course removed successfully', 'cartCount' => count($cart)]);
    }

    public function checkStatus(Request $request){
        $courseId = $request->course_id;
        $cart = session()->get('cart', []);
        if (isset($cart[$courseId])) {
            return response()->json(['success' => true, 'message' => 'Course in cart', 'cartCount' => count($cart)]);
        }
        else{
            return response()->json(['success' => true, 'message' => 'Course not in cart', 'cartCount' => count($cart)]);
        }
    }   

    public function checkout(Request $request){
        $cart = session()->get('cart', []);
        if(count($cart) == 0){
            return redirect()->route('front.courses');
        }
        $total = 0;
        foreach($cart as $item){
            $total += $item['price'];
        }
        $user = Auth::user();
        return view('front.checkout', get_defined_vars());
    }

    public function checkoutRemoveFromCart(Request $request){
        $courseId = $request->course_id;
        $cart = session()->get('cart', []);
        if (isset($cart[$courseId])) {
            unset($cart[$courseId]);
        }
        session()->put('cart', $cart);
        return response()->json(['success' => true, 'message' => 'Course removed successfully', 'cart_total' => array_sum(array_column($cart, 'price')), 'cart_count' => count($cart)]);
    }
}
