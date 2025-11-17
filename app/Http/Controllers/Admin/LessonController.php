<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CourseLesson;
use App\Models\CourseModule;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class LessonController extends Controller
{
    public function index($id)
    {
        $module = CourseModule::find($id);
        return view('admin.lesson.list', get_defined_vars());
    }

    public function showModal(Request $request)
    {
        $data = '';
        if($request->lessonId != ""){
            $data = CourseLesson::where('id', $request->lessonId)->where('course_module_id', $request->moduleId)->first();
        }
        $moduleId = $request->moduleId;
        $courseId = $request->course_id;
        return view('admin.modal.lesson', get_defined_vars());
    }

    public function store(Request $request)
    {
        if($request->lessonId == ""){
            if($request->type == "pdf"){
                $request->validate([
                    'name' => 'required',
                    'pdf_file' => 'required'
                ]);
            }
            else if($request->type == "video"){
                $request->validate([
                    'name' => 'required',
                    'video_file' => 'required'
                ]);
            }
        }
        else{
            $lesson = CourseLesson::find($request->lessonId);

            if($lesson->type == "pdf"){
                if($request->type == "pdf"){
                    $request->validate([
                        'name' => 'required'
                    ]);
                }
                else{
                    $request->validate([
                        'name' => 'required',
                        'video_file' => 'required'
                    ]);
                }
            }
            else if($lesson->type == "video"){
                if($request->type == "video"){
                    $request->validate([
                        'name' => 'required'
                    ]);
                }
                else{
                    $request->validate([
                        'name' => 'required',
                        'pdf_file' => 'required'
                    ]);
                }
            }
        }

        if($request->lessonId != ""){
            $lesson = CourseLesson::find($request->lessonId);
            $message = 'Lesson updated successfully';
            
            if($request->type == "pdf" && $request->pdf_file != ""){
                File::delete(public_path($request->hidden_file));
                $lesson->file = $this->imageUploader($request->pdf_file,'lessons/pdf');
            }
            else if($request->type == "video" && $request->video_file != ""){
                File::delete(public_path($request->hidden_file));
                $lesson->file = $request->video_file_path;
            }
        }
        else{
            $lesson = new CourseLesson();
            $message = 'Lesson created successfully';

            if($request->type == "pdf")
                $lesson->file = $this->imageUploader($request->pdf_file,'lessons/pdf');
            else
                $lesson->file = $request->video_file_path;
        }
        $lesson->course_module_id = $request->moduleId;
        $lesson->title = $request->name;
        $lesson->slug = Str::slug($request->name);
        $lesson->status = $request->status;
        $lesson->type = $request->type;
        $lesson->save();
        

        return response()->json([
            'type' => 'success',
            'message' => 'Success!',
            'message_body' => $message,
            'url' => route('admin.courses.lesson', $request->moduleId)
        ]);
    }

    public function imageUploader($file,$path)
    {
            $extension = $file->getClientOriginalExtension();
            $extension=$file->getClientOriginalName().time().'.'.$extension;
            $file->move(public_path('uploads/'.$path.'/'),$extension);
            $fileName = '/uploads/'.$path.'/'.$extension;
            return $fileName;
    }

    public function delete(Request $request)
    {
        $lesson = CourseLesson::find($request->id);
        File::delete(public_path($lesson->file));
        $lesson->delete();
        return response()->json(['success' => true]);
    }
    
    public function uploadChunk(Request $request)
    {
        $chunk = $request->file('file');
        $chunkName = $request->fileName . '_' . $request->chunkIndex;

        // Save chunks in public/chunks
        $chunk->move(public_path('chunks'), $chunkName);

        return response()->json(['status' => 'chunk uploaded']);
    }

    public function mergeChunks(Request $request)
    {
        $time = time();
        $finalPath = public_path('uploads/lessons/video/'.$time . $request->fileName);

        // Make sure videos directory exists
        if (!file_exists(public_path('uploads/lessons/video'))) {
            mkdir(public_path('uploads/lessons/video'), 0777, true);
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
            'path' => 'uploads/lessons/video/' . $time . $request->fileName // public URL
        ]);
    }

    public function deleteFile(Request $request)
    {
        File::delete(public_path($request->file_url));
        return response()->json(['success' => true]);
    }
}
