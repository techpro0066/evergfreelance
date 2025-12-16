<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BuyCourse;
use App\Models\Course;
use App\Models\CourseLesson;
use App\Models\CourseModule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class MyCoursesController extends Controller
{
    public function index(){
        // Only show courses that have been paid for
        $buyCourses = BuyCourse::where('user_id', Auth::user()->id)
            ->where('payment_status', 'paid')
            ->with('course')
            ->get();
        return view('dashboard.my-courses', get_defined_vars());
    }

    public function showCourse($slug){
        $course = Course::where('slug', $slug)->first();
        
        if (!$course) {
            return redirect()->route('dashboard.my.courses')->with('error', 'Course not found');
        }

        // Check if user has purchased and paid for this course
        $buyCourse = BuyCourse::where('user_id', Auth::user()->id)
            ->where('course_id', $course->id)
            ->where('payment_status', 'paid')
            ->first();
            
        if(!$buyCourse){
            return redirect()->route('dashboard.my.courses')
                ->with('error', 'You are not enrolled in this course or payment is pending. Please complete your payment to access this course.');
        }
        
        return view('dashboard.course', get_defined_vars());
    }

    /**
     * Securely serve course lesson files
     * This method ensures only authenticated users who have purchased the course can access files
     */
    public function downloadFile($lessonId){
        try {
            // Get the lesson
            $lesson = CourseLesson::findOrFail($lessonId);
            
            // Check if lesson has a module_id
            if (!$lesson->course_module_id) {
                Log::error('Lesson has no module ID', [
                    'lesson_id' => $lessonId,
                    'lesson_data' => $lesson->toArray()
                ]);
                abort(404, 'Lesson is not associated with any module. Please contact support.');
            }
            
            // Get the module directly using the course_module_id
            $module = CourseModule::with('course')->find($lesson->course_module_id);
            
            if (!$module) {
                Log::error('Module not found in database', [
                    'lesson_id' => $lessonId,
                    'course_module_id' => $lesson->course_module_id
                ]);
                abort(404, 'Module not found for this lesson. Please contact support.');
            }
            
            // Get the course through the module
            $course = $module->course;
            
            if (!$course) {
                Log::error('Course not found for module', [
                    'lesson_id' => $lessonId,
                    'module_id' => $module->id,
                    'course_id' => $module->course_id ?? 'null'
                ]);
                abort(404, 'Course not found for this lesson. Please contact support.');
            }
            
            // Check if user is authenticated (should be handled by middleware, but double-check)
            if (!Auth::check()) {
                Log::warning('Unauthenticated access attempt', [
                    'lesson_id' => $lessonId,
                    'ip' => request()->ip()
                ]);
                abort(403, 'Unauthorized access. Please login to access course files.');
            }
            
            // Check if user has purchased and paid for this course
            $buyCourse = BuyCourse::where('user_id', Auth::id())
                ->where('course_id', $course->id)
                ->where('payment_status', 'paid')
                ->first();
                
            if (!$buyCourse) {
                Log::warning('Unauthorized file access attempt', [
                    'user_id' => Auth::id(),
                    'course_id' => $course->id,
                    'lesson_id' => $lessonId,
                    'ip' => request()->ip()
                ]);
                abort(403, 'You are not enrolled in this course or payment is pending. Please complete your payment to access course files.');
            }
            
            // Check if file exists
            // Files are stored in public/uploads/lessons/ directory
            $filePath = public_path($lesson->file);
            
            if (!file_exists($filePath)) {
                Log::error('File not found', [
                    'lesson_id' => $lessonId,
                    'file_path' => $lesson->file,
                    'full_path' => $filePath
                ]);
                abort(404, 'File not found.');
            }
            
            // Log successful access
            Log::info('File accessed', [
                'user_id' => Auth::id(),
                'course_id' => $course->id,
                'lesson_id' => $lessonId,
                'file' => basename($lesson->file)
            ]);
            
            // Determine file type
            $fileExtension = strtolower(pathinfo($lesson->file, PATHINFO_EXTENSION));
            $isVideo = in_array($fileExtension, ['mp4', 'webm', 'ogg', 'mov', 'avi']);
            $isPdf = $fileExtension === 'pdf';
            
            // Get MIME type
            $mimeType = $this->getMimeType($filePath, $fileExtension);
            
            // Prepare security headers
            $headers = [
                'Content-Type' => $mimeType,
                'X-Content-Type-Options' => 'nosniff',
                'X-Frame-Options' => 'DENY',
                'Cache-Control' => 'private, no-cache, no-store, must-revalidate',
                'Pragma' => 'no-cache',
                'Expires' => '0',
            ];
            
            // Handle video files with range request support for streaming
            if ($isVideo) {
                $headers['Accept-Ranges'] = 'bytes';
                $headers['Content-Disposition'] = 'inline; filename="' . basename($lesson->file) . '"';
                
                // Laravel's file() method handles HTTP Range requests automatically for video streaming
                return response()->file($filePath, $headers);
            }
            
            // Handle PDF files
            if ($isPdf) {
                $headers['Content-Disposition'] = 'inline; filename="' . basename($lesson->file) . '"';
                return response()->file($filePath, $headers);
            }
            
            // Handle other file types (download)
            $headers['Content-Disposition'] = 'attachment; filename="' . basename($lesson->file) . '"';
            return response()->download($filePath, basename($lesson->file), $headers);
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Lesson not found', ['lesson_id' => $lessonId]);
            abort(404, 'Lesson not found.');
        } catch (\Exception $e) {
            Log::error('Error serving file', [
                'lesson_id' => $lessonId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            abort(500, 'An error occurred while serving the file.');
        }
    }
    
    /**
     * Get MIME type for file
     */
    private function getMimeType($filePath, $extension = null) {
        if (function_exists('mime_content_type')) {
            $mimeType = mime_content_type($filePath);
            if ($mimeType) {
                return $mimeType;
            }
        }
        
        // Fallback to extension-based MIME types
        $mimeTypes = [
            'mp4' => 'video/mp4',
            'webm' => 'video/webm',
            'ogg' => 'video/ogg',
            'mov' => 'video/quicktime',
            'avi' => 'video/x-msvideo',
            'pdf' => 'application/pdf',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
        ];
        
        if ($extension && isset($mimeTypes[$extension])) {
            return $mimeTypes[$extension];
        }
        
        return 'application/octet-stream';
    }
}
