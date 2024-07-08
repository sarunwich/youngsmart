<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Course;
use App\Models\Project;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Facades\DB;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $announcements=Announcement::join('projects', 'projects.id', '=', 'announcements.project')
        ->join('courses', 'courses.id', '=', 'announcements.course')
        ->select('announcements.*', 'projects.Projectname as Projectname', 'courses.Cosename as Cosename')
        ->orderByDesc('id')
        ->get();
        $courses = Course::where('status', '=', 1)->get();
        $projects = Project::where('status', '=', 1)->get();
        return view('admin.exam_results', compact('announcements','courses','projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $id = IdGenerator::generate(['table' => 'announcements', 'length' => 7, 'prefix' => date('ym'), 'reset_on_prefix_change' => true]);
        $validatedData = $request->validate([

            'project' => 'required',
            'courses' => 'required',
            'announcements' => 'required',
            'announcementsfile' => 'required|mimes:pdf|max:2048',
         ]);
         $name=null;
         if ($request->hasfile('announcementsfile')) {
 
             $filename = $request->file('announcementsfile')->getClientOriginalName();
             $filename = explode(".", $filename);
             $name = "Exam_" . $filename[0] . "_" . time() . rand(1, 100) . '.' . $request->announcementsfile->extension();
             $request->announcementsfile->storeAs('public/announcementsfile', $name);
             
         }
         $Announcement = Announcement::insert([
            'id'=>$id,
            'project' => $request->project,
            'course' => $request->courses,
            'announcements' =>$request->announcements,
            'announcementsfile' => $name,
            'status' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            
        ]);
        return redirect()->back()->with('status', 'Save Successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function show(Announcement $announcement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function edit(Announcement $announcement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Announcement $announcement)
    {
        //
        $id = $request->id;
        $intValue = intval($request->status);
        DB::table('announcements')
            ->where('id', $id)

            ->update(['status' => $intValue,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        return response()->json(['success' => 'Data is update']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Announcement $announcement)
    {
        //
    }
}
