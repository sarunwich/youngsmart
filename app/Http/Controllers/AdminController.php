<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Project;
use App\Models\Regist;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

class AdminController extends Controller
{
    //
    public function downloadFile($path, $filename)
    {
        $filepath = public_path('storage/' . $path . '/' . $filename);
        // marketingplan_file
        return Response::download($filepath);
        // $filePath = storage_path('app/public/' . $path . '/' . $filename);
        // $filePath = storage_path('app/public/pr_file/PR_ใบเสนอราคาสแกน_168639317856.pdf');
        // $headers = [
        //     'Content-Type' => Storage::mimeType($filePath),
        //     'Content-Disposition' => 'attachment; filename="' . basename($filePath) . '"',
        // ];

        // return new StreamedResponse(function () use ($filePath) {
        //     readfile($filePath);
        // }, 200, $headers);

    }

    public function project()
    {
        $projects = Project::all();
        return view('admin.adminproject', compact('projects'));

    }
    public function addproject(Request $request)
    {
        $validatedData = $request->validate([
            'Projectname' => 'required',
            'Projectdetail' => 'required',
            'tcas' => 'required',
            'year' => 'required',
            // 'pr_file' => 'required|mimes:pdf,docx,doc|max:2048',
        ]);
        $uid = Auth::user()->id;
        $name = null;
        if ($request->hasfile('Projectfile')) {

            $filename = $request->file('Projectfile')->getClientOriginalName();
            $filename = explode(".", $filename);
            $name = "P_" . $filename[0] . "_" . time() . rand(1, 100) . '.' . $request->Projectfile->extension();
            $request->Projectfile->storeAs('public/Projectfile', $name);

        }
        $id = IdGenerator::generate(['table' => 'projects', 'length' => 7, 'prefix' => date('ym'), 'reset_on_prefix_change' => true]);

        $data = [
            'id' => $id,
            'Projectname' => $request->Projectname,
            'Projectdetail' => $request->Projectdetail,
            'tcas' => $request->tcas,
            'year' => $request->year,
            'Projectfile' => $name,
            'status' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),

            // Add more columns and values as needed
        ];

        $status_update = Project::insert($data);
        // $project=Project::create($data);
        //  dd( $id ,$project);
        // Alternatively, you can use the new instance directly
        // $model = new PublicRelations($data);
        // $model->save();

        return redirect()->back();

    }
    public function cose()
    {
        $coses = Course::all();
        return view('admin.admincouse', compact('coses'));
    }
    public function addcose(Request $request)
    {
        $validatedData = $request->validate([
            'Cosename' => 'required',
            'Cosefile' => 'required',
            'datestart' => 'required',
            'dateend' => 'required',
        ]);
        $id = IdGenerator::generate(['table' => 'courses', 'length' => 7, 'prefix' => date('ym'), 'reset_on_prefix_change' => true]);
        $name = null;
        if ($request->hasfile('Cosefile')) {

            $filename = $request->file('Cosefile')->getClientOriginalName();
            $filename = explode(".", $filename);
            $name = "P_" . $filename[0] . "_" . time() . rand(1, 100) . '.' . $request->Cosefile->extension();
            $request->Cosefile->storeAs('public/Cosefile', $name);

        }
        $status_update = Course::insert(
            [
                'id' => $id,
                'Cosename' => $request->Cosename,
                'Cosefile' => $name,
                'datestart' => $request->datestart,
                'dateend' => $request->dateend,
                'status' => 1,
            ]
        );
        return redirect()->back();
    }
    public function regist(Request $request)
    {
        // $regists = Regist::join('projects', 'projects.id', '=', 'regists.project')
        //     ->join('courses', 'courses.id', '=', 'regists.course')
        //     ->select('regists.*', 'projects.Projectname as Projectname', 'courses.Cosename as Cosename')
        //     ->orderByDesc('id')
        //     ->get();

        $perPage = 10; // Number of items to display per page
        $search = $request->input('search'); // Search keyword

        $regists = Regist::query()
            ->join('projects', 'projects.id', '=', 'regists.project')
            ->join('courses', 'courses.id', '=', 'regists.course')
            ->join('users', 'users.id', '=', 'regists.iduser')
            ->select('regists.*', 'projects.Projectname as Projectname', 'courses.Cosename as Cosename', 'users.name as name', 'users.prefix as p')
            ->orderByDesc('id');

        if ($search) {
            $regists->where('name', 'LIKE', '%' . $search . '%')
                ->orWhere('projects.Projectname', 'LIKE', '%' . $search . '%')
                ->orWhere('courses.Cosename', 'LIKE', '%' . $search . '%');
        }

        // Retrieve paginated data
        $regists = $regists->paginate($perPage);
        return view('admin.registdetail', compact('regists', 'search'));
    }
    public function upstatus(Request $request)
    {
        Regist::where('id', $request->idreg)
            ->update(
                [
                    'std_status' => $request->updstatus,
                ]
            );
        return redirect()->back()->with('status', 'Updated Successfully');

    }
    public function Prteacher(Request $request)
    {
        Project::where('id', $request->id)
            ->update(
                [
                    'teacher' => $request->status,
                ]
            );
        return redirect()->back()->with('status', 'Updated Successfully');
    }
    public function PUpstatus(Request $request)
    {
        Project::where('id', $request->id)
            ->update(
                [
                    'status' => $request->status,
                ]
            );
        return redirect()->back()->with('status', 'Updated Successfully');
    }

    public function viewregistsdetail(Request $request)
    {
        $regists = Regist::where('regists.id', '=', $request->id)
        //where('iduser','=',Auth::user()->id)
            ->join('projects', 'projects.id', '=', 'regists.project')
            ->join('courses', 'courses.id', '=', 'regists.course')
            ->join('users', 'users.id', '=', 'regists.iduser')
            ->select('regists.*', 'projects.Projectname as Projectname', 'courses.Cosename as Cosename', 'users.name as name', 'users.prefix as p' , 'users.idcard as idcard' , 'users.belong as belong','users.gread as gread','users.level as level','users.province as province','users.address as address','users.tel as tel','users.parent_tel as parent_tel','users.parent_name as parent_name')
            ->orderByDesc('regists.id')
            ->first();

        return view('admin.viewregistsdetail', compact('regists'));
    }

}
