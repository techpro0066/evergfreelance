<?php

use App\Http\Controllers\UserProfileContoller;
use Illuminate\Support\Facades\Route;

// Middleware
use App\Http\Middleware\CheckAdmin;

// Admin Controllers
use App\Http\Controllers\Admin\CoursesController;
use App\Http\Controllers\Admin\ModuleController;
use App\Http\Controllers\Admin\LessonController;
use App\Http\Controllers\Admin\UserController;

// Front Controllers
use App\Http\Controllers\FrontController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\MyCoursesController;

Route::get('/', function () {
    return view('front.index');
});

Route::get('/404', function () {
    return view('error.404');
})->name('404');

Route::middleware(['auth', 'verified'])->group(function(){
    Route::get('/dashboard', [UserProfileContoller::class, 'index'])->name('dashboard');
});

Route::middleware(['auth'])->group(function(){
    Route::get('/profile', [UserProfileContoller::class, 'profile'])->name('profile');
    Route::post('/profile/update', [UserProfileContoller::class, 'update'])->name('profile.update');
    Route::post('/profile/changePassword', [UserProfileContoller::class, 'changePassword'])->name('profile.changePassword');

    // Payment routes
    Route::post('/checkout/create-payment-intent', [CheckoutController::class, 'createPaymentIntent'])->name('checkout.create.payment.intent');
    Route::post('/checkout/process-payment', [CheckoutController::class, 'processPayment'])->name('checkout.process.payment');
    Route::post('/checkout/verify-payment', [CheckoutController::class, 'verifyPayment'])->name('checkout.verify.payment');
    Route::post('/checkout', [CheckoutController::class, 'checkout'])->name('checkout'); // Keep for backward compatibility

    Route::controller(MyCoursesController::class)->group(function(){
        Route::get('/dashboard/mycourses', 'index')->name('dashboard.my.courses');
        Route::get('/dashboard/{slug}', 'showCourse')->name('dashboard.my.courses.show');
        Route::get('/dashboard/lesson/{lessonId}/file', 'downloadFile')->name('dashboard.lesson.file');
    });
});

// Webhook route (no auth required, but should verify signature)
Route::post('/webhooks/paymongo', [CheckoutController::class, 'webhook'])->name('webhooks.paymongo');

Route::middleware(['auth', CheckAdmin::class])->name('admin.')->group(function () {

    Route::controller(CoursesController::class)->group(function(){
        Route::get('/admin/courses', 'index')->name('courses');
        Route::get('/admin/courses/create/{id?}', 'create')->name('courses.create');
        Route::post('/admin/courses/store', 'store')->name('courses.store');
        Route::post('/admin/courses/delete', 'delete')->name('courses.delete');
        
        Route::post('/upload-course-chunk', [CoursesController::class, 'uploadChunk']);
        Route::post('/merge-course-chunks', [CoursesController::class, 'mergeChunks']);
        Route::delete('/delete-course-file', [CoursesController::class, 'deleteFile'])->name('course.file.delete');
        Route::post('/delete-course-file', [CoursesController::class, 'deleteFile']); // POST route for cleanup on page unload
    });

    Route::controller(ModuleController::class)->group(function(){
        Route::get('/admin/courses/module/{id}', 'index')->name('courses.module');
        Route::post('/admin/courses/module/modal', 'showModal')->name('courses.module.modal');
        Route::post('/admin/courses/module/store', 'store')->name('courses.module.store');
        Route::post('/admin/courses/module/delete', 'delete')->name('courses.module.delete');
    });

    Route::controller(LessonController::class)->group(function(){
        Route::get('/admin/courses/lesson/{id}', 'index')->name('courses.lesson');
        Route::post('/admin/courses/lesson/modal', 'showModal')->name('courses.lesson.modal');
        Route::post('/admin/courses/lesson/store', 'store')->name('courses.lesson.store');
        Route::post('/admin/courses/lesson/delete', 'delete')->name('courses.lesson.delete');

        Route::delete('/delete-file', [LessonController::class, 'deleteFile'])->name('file.delete');

        Route::post('/upload-chunk', [LessonController::class, 'uploadChunk']);
        Route::post('/merge-chunks', [LessonController::class, 'mergeChunks']); 
    });

    Route::controller(UserController::class)->group(function(){
        Route::get('/admin/users', 'index')->name('users');
        Route::post('/admin/users/courses', 'courses')->name('users.courses');
    });
});

Route::name('front.')->group(function(){
    Route::get('/courses', [FrontController::class, 'courses'])->name('courses');
    Route::get('/courses/{slug}', [FrontController::class, 'courseDetail'])->name('course.detail');
    Route::get('/about-us', [FrontController::class, 'aboutUs'])->name('about.us');
    Route::get('/faq', [FrontController::class, 'faq'])->name('faq');
    Route::get('/contact', [FrontController::class, 'contact'])->name('contact');
    Route::post('/add-to-cart', [FrontController::class, 'addToCart'])->name('add.to.cart');
    Route::post('/remove-from-cart', [FrontController::class, 'removeFromCart'])->name('remove.from.cart');
    Route::post('/check-status', [FrontController::class, 'checkStatus'])->name('check.status');
    Route::get('/checkout', [FrontController::class, 'checkout'])->name('checkout');
    Route::post('/checkout-remove-from-cart', [FrontController::class, 'checkoutRemoveFromCart'])->name('checkout.remove.from.cart');
});

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__.'/auth.php';
