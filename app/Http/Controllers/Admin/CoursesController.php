<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class CoursesController extends Controller
{
    public function index()
    {
        $list = Course::all();
        return view('admin.courses.list', get_defined_vars());
    }

    public function create($id = null)
    {
        $course = null;
        if(!is_null($id)){
            $course = Course::find($id);
        }
        return view('admin.courses.create', get_defined_vars());
    }

    public function store(Request $request)
    {
        if(!is_null($request->id)){
            $request->validate([
                'title' => 'required',
                'header' => 'required',
                'description' => 'required',
                'price' => 'required|numeric'
            ]);

            $course = Course::find($request->id);
            $message = 'Course updated successfully';

            $course->thumbnail = $request->old_thumbnail;

        }else{
            $request->validate([
                'title' => 'required',
                'header' => 'required',
                'description' => 'required',
                'price' => 'required|numeric',
                'thumbnail' => 'required',
            ]);

            $course = new Course();
            $message = 'Course created successfully';
        }

        if($request->hasFile('thumbnail')){
            // delete old thumbnail
            if(!is_null($request->old_thumbnail)){
                File::delete(public_path($request->old_thumbnail));
            }

            // upload new thumbnail
            $thumbnail = $request->file('thumbnail');
            $thumbnailName = time() . '.' . $thumbnail->getClientOriginalExtension();
            $thumbnail->move(public_path('uploads/courses'), $thumbnailName);
            $course->thumbnail = 'uploads/courses/'.$thumbnailName;
        }

        $course->title = $request->title;
        $course->header = $request->header;
        $course->description = $request->description;
        $course->price = $request->price;
        $course->status = $request->status;
        $course->slug = Str::slug($request->title);

        $course->save();

        return redirect()->route('admin.courses')->with('success', $message);
    }

    public function delete(Request $request)
    {
        $course = Course::find($request->id);
        if(!is_null($course->thumbnail)){
            File::delete(public_path($course->thumbnail));
        }
        $course->delete();
        return response()->json(['success' => true]);
    }
}
