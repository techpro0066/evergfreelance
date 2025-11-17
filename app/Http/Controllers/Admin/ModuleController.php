<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\CourseModule;
use Illuminate\Support\Str;

class ModuleController extends Controller
{
    public function index($id){
        $course = Course::find($id);
        $modules = $course->modules;
        return view('admin.module.list', get_defined_vars());
    }

    public function showModal(Request $request)
    {
        $data = '';
        if($request->moduleId != ""){
            $data = CourseModule::where('id', $request->moduleId)->where('course_id', $request->course_id)->first();
        }
        $course_id = $request->course_id;
        return view('admin.modal.module', get_defined_vars());
    }

    public function store(Request $request)
    {
        $request->validate([
            'moduleName' => 'required',
        ]);

        if($request->moduleId != ""){
            $module = CourseModule::find($request->moduleId);
            $message = 'Module updated successfully';
        }
        else{
            $module = new CourseModule();
            $message = 'Module created successfully';
        }

        $module->course_id = $request->course_id;
        $module->title = $request->moduleName;
        $module->status = $request->moduleStatus;
        $module->slug = Str::slug($request->moduleName);
        $module->save();

        return response()->json([
            'type' => 'success',
            'message' => 'Success!',
            'message_body' => $message,
            'url' => route('admin.courses.module', $request->course_id)
        ]);
    }

    public function delete(Request $request)
    {
        $module = CourseModule::find($request->id);
        $module->delete();
        return response()->json(['success' => true]);
    }
}
