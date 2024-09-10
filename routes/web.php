<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicRelationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MyController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TeacherResponsibleController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {return view('home');});
Route::get('/contact', function () {return view('contact');});
Route::get('/news', [MyController::class, 'news'])->name('news');
Route::get('viewfile/{path}/{file_name}', [MyController::class, 'downloadFile']);
Route::get('/project',  [MyController::class, 'project']);
Route::get('/courses',  [MyController::class, 'courses']);
Route::get('/result', [MyController::class, 'result'])->name('result');
Route::get('/registdata', [MyController::class, 'registdata'])->name('registdata');



Auth::routes();

/*------------------------------------------
--------------------------------------------
All Normal Users Routes List
--------------------------------------------
--------------------------------------------*/
Route::middleware(['auth', 'user-access:user'])->group(function () {
  
    Route::get('/user/home', [App\Http\Controllers\HomeController::class, 'index'])->name('user.home');
Route::get('/user/contact', function () {return view('frontend.contact');})->name('user.contact');
Route::get('user/news', [HomeController::class, 'news'])->name('user.news');
Route::get('user/project', [HomeController::class, 'project'])->name('user.project');
Route::get('user/courses', [HomeController::class, 'courses'])->name('user.courses');
Route::get('user/regist', [HomeController::class, 'regist'])->name('user.regist');
Route::post('user/regist', [HomeController::class, 'registdb'])->name('user.registdb');
Route::get('user/registdetail', [HomeController::class, 'registdetail'])->name('user.registdetail');
Route::post('user/viewregistsdetail', [HomeController::class, 'viewregistsdetail'])->name('user.viewregistsdetail');
Route::get('get/{path}/{file_name}', [HomeController::class, 'downloadFile']);
Route::post('user/uppayment', [HomeController::class, 'uppayment'])->name('user.uppayment');
Route::get('user/result', [HomeController::class, 'result'])->name('frontend.result');
Route::post('user/checkteacher', [HomeController::class, 'checkteacher'])->name('user.checkteacher');
Route::post('user/uploadpicFile', [HomeController::class, 'uploadpicFile'])->name('uploadpicFile');
Route::post('user/uploadcustomFile', [HomeController::class, 'uploadcustomFile'])->name('uploadcustomFile');
Route::post('user/uploadportfolio_file', [HomeController::class, 'uploadportfolio_file'])->name('uploadportfolio_file');
Route::post('user/uploadguidance_teacher', [HomeController::class, 'uploadguidance_teacher'])->name('uploadguidance_teacher');

// Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
// Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
// Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
  
/*------------------------------------------
--------------------------------------------
All Admin Routes List
--------------------------------------------
--------------------------------------------*/
Route::middleware(['auth', 'user-access:admin'])->group(function () {
  
    // Route::get('/admin/home', [HomeController::class, 'adminHome'])->name('admin.home');
    Route::get('/admin', function () {
        return view('admin.dashboard');
    })->name('dashboard');
    Route::get('admin/news',[PublicRelationController::class, 'index'])->name('admin.news');
    Route::post('addnew/addnew',[PublicRelationController::class, 'addnew'])->name('addnew.create');
    Route::delete('/data/{id}',[PublicRelationController::class,'destroy'])->name('data.destroy');
    Route::get('getfile/{path}/{file_name}', [AdminController::class, 'downloadFile']);
    Route::post('admin/PrUpstatus',[PublicRelationController::class, 'PrUpstatus']);
    Route::get('admin/contact', function () {return view('admin.contact');})->name('admin.contact');
    Route::get('admin/project',[AdminController::class, 'project'])->name('admin.project');
    Route::post('addproject/project',[AdminController::class, 'addproject'])->name('addproject.create');

    Route::get('admin/cose',[AdminController::class, 'cose'])->name('admin.cose');
    Route::post('addcose/project',[AdminController::class, 'addcose'])->name('addcose.create');

    Route::get('admin/regist',[AdminController::class, 'regist'])->name('admin.regist');
    Route::post('admin/upstatus',[AdminController::class, 'upstatus'])->name('admin.upstatus');
    Route::post('admin/Prteacher',[AdminController::class, 'Prteacher'])->name('admin.Prteacher');
    Route::post('admin/PUpstatus',[AdminController::class, 'PUpstatus'])->name('admin.PUpstatus');
    Route::post('admin/CouseUpstatus',[AdminController::class, 'CouseUpstatus'])->name('admin.CouseUpstatus');
    
    Route::get('admin/exam_results',[AnnouncementController::class, 'index'])->name('admin.exam_results');
    Route::post('results/create',[AnnouncementController::class, 'store'])->name('results.create');
    Route::post('admin/Exam_upstatus',[AnnouncementController::class, 'update'])->name('admin.Exam_upstatus');
    Route::post('admin/viewregistsdetail', [AdminController::class, 'viewregistsdetail'])->name('admin.viewregistsdetail');
    Route::put('/projects/{id}', [ProjectController::class, 'update'])->name('projects.update');
    Route::put('/updatecose/{id}', [CourseController::class, 'update'])->name('courses.update');
    Route::delete('/courses/{id}', [CourseController::class, 'destroy'])->name('courses.destroy');
    Route::delete('/projects/{id}', [CourseController::class, 'destroy'])->name('Projectfile.destroy');

    Route::get('admin/config',[AdminController::class, 'config'])->name('admin.config');
    Route::post('admin/configdb', [AdminController::class, 'configdb'])->name('admin.configdb');
    Route::delete('/responsibles/{id}', [AdminController::class, 'deleteResponsible'])->name('responsibles.destroy');
    Route::delete('/registdestroy/{id}', [AdminController::class, 'deleteRegist'])->name('regist.destroy');

    Route::get('admin/adduser_teacher',[AdminController::class, 'adduser_teacher'])->name('admin.adduser_teacher');
   
   
    
});
  
/*------------------------------------------
--------------------------------------------
All Admin Routes List
--------------------------------------------
--------------------------------------------*/
Route::middleware(['auth', 'user-access:manager'])->group(function () {
  
    Route::get('/manager/home', [HomeController::class, 'managerHome'])->name('manager.home');
    
    Route::resource('TeacherResponsible', TeacherResponsibleController::class);

});



// Route::middleware(['auth', 'isAdmin'])->group(function () {
   
    
// });
