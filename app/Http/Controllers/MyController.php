<?php

namespace App\Http\Controllers;
use App\Models\PublicRelation;
use Illuminate\Support\Facades\Response;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Course;
use App\Models\Announcement;
use App\Models\Regist;
use Illuminate\Http\Request;

class MyController extends Controller
{
    //
    public function news()
    {
        $news=PublicRelation::all();
        return view('news',compact('news'));
    }
    public function downloadFile($path, $filename)
    {
        $filepath = public_path('storage/' . $path . '/' . $filename);
        // marketingplan_file
        return Response::download($filepath);
        
    }
    public function project()
    {
        $projects=Project::all();
        return view('project',compact('projects'));
    }
    public function courses()
    {
        $courses=Course::all();
        return view('course',compact('courses'));
    }
    public function result()
    {
        $announcements=Announcement::join('projects', 'projects.id', '=', 'announcements.project')
        ->join('courses', 'courses.id', '=', 'announcements.course')
        ->where('announcements.status','=',1)
        ->select('announcements.*', 'projects.Projectname as Projectname', 'courses.Cosename as Cosename')
        ->orderByDesc('id')
        ->get();
        return view('result',compact('announcements'));
    }
    public function registdata(Request $request)
    {
        $perPage = 10; // Number of items to display per page
        $search = $request->input('search'); // Search keyword

        $regists = Regist::query()
        ->join('projects', 'projects.id', '=', 'regists.project')
            ->join('courses', 'courses.id', '=', 'regists.course')
            ->join('users', 'users.id', '=', 'regists.iduser')
            ->select('regists.*', 'projects.Projectname as Projectname', 'courses.Cosename as Cosename','users.name as name','users.prefix as p')
            ->orderByDesc('id');
            
            if ($search) {
                $regists->where('name', 'LIKE', '%' . $search . '%')
                    ->orWhere('projects.Projectname', 'LIKE', '%' . $search . '%')
                    ->orWhere('courses.Cosename', 'LIKE', '%' . $search . '%');
            }
        
            // Retrieve paginated data
            $data = $regists->paginate($perPage);
        return view('registdata', compact('data', 'search'));
    }
}
