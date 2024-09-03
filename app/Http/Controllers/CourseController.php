<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CourseController extends Controller
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
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'Cosename' => 'required|string|max:255',
            'datestart' => 'required|date',
            'dateend' => 'required|date',
            'Cosefile' => 'nullable|file|mimes:pdf|max:2048', // Adjust validation rules as needed
        ]);

        // Find the course by ID
        $course = Course::findOrFail($id);

        // Update course details
        $course->Cosename = $request->input('Cosename');
        $course->datestart = $request->input('datestart');
        $course->dateend = $request->input('dateend');

        // Handle file upload
        if ($request->hasFile('Cosefile')) {
            // Delete old file if it exists
            // if ($course->Cosefile) {
            //     Storage::delete($course->Cosefile);
            // }

            // Store the new file and get its path
            $filename = $request->file('Cosefile')->getClientOriginalName();
            $filename = explode(".", $filename);
            $name = "P_" . $filename[0] . "_" . time() . rand(1, 100) . '.' . $request->Cosefile->extension();
            $request->Cosefile->storeAs('public/Cosefile', $name);

            // $filePath = $request->file('Cosefile')->store('public/courses');
            // $course->Cosefile = basename($filePath);
        }

        // Save the updated course
        $course->save();

        // Redirect or return response
        return redirect()->back()->with('success', 'Course updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $course = Course::findOrFail($id);
        $course->status = '0';
        $course->delstatus = 1;
        $course->save();
        return redirect()->back()->with('success', 'Course deleted successfully.');
    }
}
