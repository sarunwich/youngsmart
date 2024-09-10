<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Regist;
use Illuminate\Support\Facades\Auth;

class TeacherResponsibleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $regists = Regist::query()
        ->join('projects', 'projects.id', '=', 'regists.project')
        ->join('courses', 'courses.id', '=', 'regists.course')
        // ->join('responsibles','responsibles.user_id','=',Auth::user()->id)
        // ->join('courses','courses.id', '=','responsibles.course_id')

        ->join('responsibles', function($join) {
            $join->on('responsibles.course_id', '=', 'courses.id')
                 ->where('responsibles.user_id', '=', Auth::user()->id);
        })
        ->join('users', 'users.id', '=', 'regists.iduser')
        ->select('regists.*', 'projects.Projectname as Projectname', 'courses.Cosename as Cosename', 'users.name as name', 'users.prefix as p')
        ->orderByDesc('id');
        // // dd($regists);

       
            $regists = $regists->get();
        return view('TeacherResponsible.index', compact('regists'));
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
