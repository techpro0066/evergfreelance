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

        // Prioritize chunked upload path over file input
        // If video_file_path exists, it means chunked upload was used
        if($request->has('video_file_path') && $request->video_file_path != ''){
            // Handle chunked upload video path
            if(!empty($request->old_video) && $request->old_video != $request->video_file_path){
                File::delete(public_path($request->old_video));
            }
            $course->video = $request->video_file_path;
        } else if(!is_null($request->id) && !empty($request->old_video)){
            // When editing and no new video uploaded, keep the old video
            $course->video = $request->old_video;
        }

        $course->title = $request->title;
        $course->header = $request->header;
        $course->description = $request->description;
        $course->price = $request->price;
        $course->status = $request->status;
        $course->slug = Str::slug($request->title);

        $course->save();

        // Handle AJAX requests
        if($request->ajax() || $request->wantsJson()){
            return response()->json([
                'success' => true,
                'message' => $message,
                'redirect' => route('admin.courses')
            ]);
        }

        return redirect()->route('admin.courses')->with('success', $message);
    }

    public function delete(Request $request)
    {
        $course = Course::find($request->id);
        if(!is_null($course->thumbnail)){
            File::delete(public_path($course->thumbnail));
        }
        if(!is_null($course->video)){
            File::delete(public_path($course->video));
        }
        $course->delete();
        return response()->json(['success' => true]);
    }

    public function uploadChunk(Request $request)
    {
        $chunk = $request->file('file');
        $chunkName = $request->fileName . '_' . $request->chunkIndex;

        // Make sure chunks directory exists
        if (!file_exists(public_path('chunks'))) {
            mkdir(public_path('chunks'), 0777, true);
        }

        // Save chunks in public/chunks
        $chunk->move(public_path('chunks'), $chunkName);

        return response()->json(['status' => 'chunk uploaded']);
    }

    public function mergeChunks(Request $request)
    {
        $time = time();
        $finalPath = public_path('uploads/courses/videos/'.$time . $request->fileName);

        // Make sure videos directory exists
        if (!file_exists(public_path('uploads/courses/videos'))) {
            mkdir(public_path('uploads/courses/videos'), 0777, true);
        }

        $file = fopen($finalPath, 'ab'); // append mode

        for ($i = 0; $i < $request->totalChunks; $i++) {
            $chunkPath = public_path('chunks/' . $request->fileName . '_' . $i);

            if (!file_exists($chunkPath)) {
                return response()->json(['error' => "Missing chunk: $i"], 400);
            }

            $chunk = fopen($chunkPath, 'rb');
            stream_copy_to_stream($chunk, $file);
            fclose($chunk);

            unlink($chunkPath); // delete chunk
        }

        fclose($file);

        return response()->json([
            'status' => 'merged',
            'path' => 'uploads/courses/videos/' . $time . $request->fileName // public URL
        ]);
    }

    public function deleteFile(Request $request)
    {
        if($request->has('file_url') && $request->file_url != '') {
            $filePath = public_path($request->file_url);
            if(file_exists($filePath)) {
                File::delete($filePath);
            }
        }
        if($request->has('id') && $request->id != ''){
            $course = Course::find($request->id);
            $course->video = null;
            $course->save();
        }
        return response()->json(['success' => true]);
    }
}
