<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BuyCourse;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;

class MyCoursesController extends Controller
{
    public function index(){
        $buyCourses = BuyCourse::where('user_id', Auth::user()->id)->get();
        return view('dashboard.my-courses', get_defined_vars());
    }

    public function showCourse($slug){
        $course = Course::where('slug', $slug)->first();
        $buyCourse = BuyCourse::where('user_id', Auth::user()->id)->where('course_id', $course->id)->first();
        if(!$buyCourse){
            return redirect()->route('dashboard.my.courses')->with('error', 'You are not enrolled in this course');
        }
        return view('dashboard.course', get_defined_vars());
    }
}
