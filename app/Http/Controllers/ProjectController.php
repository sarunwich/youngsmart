<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
{
    $project = Project::find($id);
    $project->Projectname = $request->input('Projectname');
    $project->Projectdetail = $request->input('Projectdetail');
    $project->tcas = $request->input('tcas');
    $project->year = $request->input('year');

    if ($request->hasFile('Projectfile')) {
        $filename = $request->file('Projectfile')->getClientOriginalName();
        $filename = explode(".", $filename);
        $name = "P_" . $filename[0] . "_" . time() . rand(1, 100) . '.' . $request->Projectfile->extension();
        $request->Projectfile->storeAs('public/Projectfile', $name);
        $project->Projectfile = $filename;
    }

    $project->save();

    // return redirect()->route('projects.index')->with('success', 'Project updated successfully');
    return redirect()->back()->with('success', 'Project updated successfully');
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $course = Project::findOrFail($id);
        $course->status = '0';
        $course->delstatus = '1';
        $course->save();
        return redirect()->back()->with('success', 'Project deleted successfully.');

    }
}
