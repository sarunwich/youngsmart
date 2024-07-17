<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Course;
use App\Models\Project;
use App\Models\PublicRelation;
use App\Models\Regist;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // return view('frontend.welcome');
        $news = PublicRelation::all();
        return view('frontend.news', compact('news'));
    }
    public function news()
    {
        $news = PublicRelation::all();
        return view('frontend.news', compact('news'));
    }
    public function project()
    {
        $projects = Project::all();
        return view('frontend.project', compact('projects'));
    }
    public function courses()
    {
        $courses = Course::all();
        return view('frontend.course', compact('courses'));
    }
    public function regist()
    {
        $courses = Course::where('status', '=', 1)->get();
        $projects = Project::where('status', '=', 1)->get();
        return view('frontend.regist', compact('courses', 'projects'));
    }
    public function registdb(Request $request)
    {
        $validatedData = $request->validate([
            'project' => 'required',
            'courses' => 'required',
            'facebook' => 'required',
            'line' => 'required',
            'picFile' => 'required',
            'customFile' => 'required',
            'portfolio_file' => 'required',

        ]);

        if ($request->hasfile('picFile')) {

            $filename = $request->file('picFile')->getClientOriginalName();
            $filename = explode(".", $filename);
            $namepicFile = "P_" . $filename[0] . "_" . time() . rand(1, 100) . '.' . $request->picFile->extension();
            $request->picFile->storeAs('public/picFile', $namepicFile);

        }
        if ($request->hasfile('customFile')) {

            $filename = $request->file('customFile')->getClientOriginalName();
            $filename = explode(".", $filename);
            $namecustomFile = "C_" . $filename[0] . "_" . time() . rand(1, 100) . '.' . $request->customFile->extension();
            $request->customFile->storeAs('public/customFile', $namecustomFile);

        }
        if ($request->hasfile('portfolio_file')) {

            $filename = $request->file('portfolio_file')->getClientOriginalName();
            $filename = explode(".", $filename);
            $nameportfolio_file = "P_" . $filename[0] . "_" . time() . rand(1, 100) . '.' . $request->portfolio_file->extension();
            $request->portfolio_file->storeAs('public/portfolio_file', $nameportfolio_file);

        }
        $nameguidance_teacher = null;
        if ($request->hasfile('guidance_teacher')) {

            $filename = $request->file('guidance_teacher')->getClientOriginalName();
            $filename = explode(".", $filename);
            $nameguidance_teacher = "GT_" . $filename[0] . "_" . time() . rand(1, 100) . '.' . $request->guidance_teacher->extension();
            $request->guidance_teacher->storeAs('public/guidance_teacher', $nameguidance_teacher);

        }

        $id = IdGenerator::generate(['table' => 'regists', 'length' => 7, 'prefix' => date('ym'), 'reset_on_prefix_change' => true]);
        $data = [
            'id' => $id,
            'project' => $request->project,
            'course' => $request->courses,
            'iduser' => Auth::user()->id,
            'link' => $request->link,
            'facebook' => $request->facebook,
            'line' => $request->line,
            'stdpic' => $namepicFile,
            'school_record' => $namecustomFile,
            'portfolio_file' => $nameportfolio_file,
            'guidance_teacher' => $nameguidance_teacher,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),

            // Add more columns and values as needed
        ];
        $status_update = Regist::insert($data);
        return redirect('user/home');

    }
    public function registdetail()
    {
        $regists = Regist::where('iduser', '=', Auth::user()->id)
            ->join('projects', 'projects.id', '=', 'regists.project')
            ->join('courses', 'courses.id', '=', 'regists.course')
            ->select('regists.*', 'projects.Projectname as Projectname', 'courses.Cosename as Cosename')
            ->orderByDesc('id')
            ->get();
        return view('frontend.registdetail', compact('regists'));
    }
    public function viewregistsdetail(Request $request)
    {
        $regists = Regist::where('regists.id', '=', $request->id)
        //where('iduser','=',Auth::user()->id)
            ->join('projects', 'projects.id', '=', 'regists.project')
            ->join('courses', 'courses.id', '=', 'regists.course')
        // ->where('regists', 'regists.id','=',$request->id)
            ->select('regists.*', 'projects.Projectname as Projectname', 'courses.Cosename as Cosename')
            ->orderByDesc('regists.id')
            ->first();
            
        return view('frontend.viewregistsdetail', compact('regists'));
    }
    public function downloadFile($path, $filename)
    {

        $filepath = public_path('storage/' . $path . '/' . $filename);
        // marketingplan_file
        return Response::download($filepath);

    }
    public function uppayment(Request $request)
    {
        if ($request->hasfile('payment')) {

            $filename = $request->file('payment')->getClientOriginalName();
            $filename = explode(".", $filename);
            $namepicFile = "PAY_" . $filename[0] . "_" . time() . rand(1, 100) . '.' . $request->payment->extension();
            $request->payment->storeAs('public/payment', $namepicFile);

        }
        Regist::where('id', $request->idreg)
            ->update(
                ['payment' => $namepicFile,
                    'dateup_p' => date('Y-m-d H:i:s'),
                    'std_status' => 1,
                ]
            );
        return redirect()->back()->with('status', 'Updated Successfully');
    }
    public function result()
    {
        $announcements = Announcement::join('projects', 'projects.id', '=', 'announcements.project')
            ->join('courses', 'courses.id', '=', 'announcements.course')
            ->where('announcements.status', '=', 1)
            ->select('announcements.*', 'projects.Projectname as Projectname', 'courses.Cosename as Cosename')
            ->orderByDesc('id')
            ->get();
        return view('frontend.result', compact('announcements'));
    }
    public function checkteacher(Request $request)
    {
        $projects = project::where('projects.id', '=', $request->id)->first();

        return response($projects->teacher);
    }
}
