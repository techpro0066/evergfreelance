<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.users.list', get_defined_vars());
    }

    public function courses(Request $request)
    {
        $user = User::find($request->id);
        $courses = $user->buyCourses;
        return view('admin.modal.courses', get_defined_vars());
    }
}
