<?php

namespace App\Http\Controllers;

use App\Models\CourseProject;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Course;

class CourseProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $projects = Project::where('status','=',1)->with('courses')->get();
        return view('course_project.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $projects = Project::all();
        $courses = Course::all();
        return view('course_project.create', compact('projects', 'courses'));
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
        $project = Project::findOrFail($request->project_id);
        $project->courses()->sync($request->courses);

        return redirect()->route('course_project.index')->with('success', 'Courses assigned to project successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CourseProject  $courseProject
     * @return \Illuminate\Http\Response
     */
    public function show(CourseProject $courseProject)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CourseProject  $courseProject
     * @return \Illuminate\Http\Response
     */
    public function edit(CourseProject $courseProject,$id)
    {
        //
        $project = Project::with('courses')->findOrFail($id);
        $courses = Course::all();
        return view('course_project.edit', compact('project', 'courses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CourseProject  $courseProject
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CourseProject $courseProject,$id)
    {
        //
        $project = Project::findOrFail($id);
        $project->courses()->sync($request->courses); // Update the association

        return redirect()->route('course_project.index')->with('success', 'Project courses updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CourseProject  $courseProject
     * @return \Illuminate\Http\Response
     */
    public function destroy(CourseProject $courseProject,$id)
    {
        //
        $project = Project::findOrFail($id);
        $project->courses()->detach(); // Remove all course associations

        return redirect()->route('course_project.index')->with('success', 'All courses detached from project');

    }
}
