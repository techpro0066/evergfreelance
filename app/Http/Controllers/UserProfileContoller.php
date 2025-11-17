<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;  
use App\Models\User;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;
use App\Models\Course;
use App\Models\BuyCourse;

class UserProfileContoller extends Controller
{
    public function index(){
        if(Auth::user()->role == 'admin'){
            $courses = Course::all()->count();
            $users = User::all()->count();
        }
        else{
            $courses = BuyCourse::where('user_id', Auth::user()->id)->count();
        }
        return view('dashboard.index', get_defined_vars()); 
    }

    public function profile(){
        return view('dashboard.profile.index');
    }

    public function update(Request $request){
        $request->validate([
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
        ]);

        $user = User::find(Auth::user()->id);
        $user->first_name = $request->firstName;
        $user->last_name = $request->lastName;
        $user->save();

        return redirect()->route('profile')->with('success', 'Profile updated successfully');
    }

    public function changePassword(Request $request){

        $request->validate([
            'password'=>'required',
            'new_password'=>'min:8|required_with:confirm_new_password|same:confirm_new_password'
        ]);
        
        $id = Auth::user()->id;
        $user = User::findOrFail($id);
        if(!Hash::check($request->password, $user->password)) 
        {
            return redirect()->back()->withErrors(['password' => 'Password Not Match']);
        }
        else
        {
            $user->password = $request->input('new_password');
            $user->update();
        }
        return redirect()->route('profile')->with('success','Password Successfully Updated!');
    }
}
