<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\SendMail;
use App\Models\Course;
use App\Models\Project;
use App\Models\Regist;
use App\Models\Responsible;
use App\Models\User;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;

class AdminController extends Controller
{
    //
    public function config()
    {
        $users = User::where('type', '=', 2)->get();
        $courses = Course::where('status', '=', 1)->get();
        // $users_courses = User::where('type', 2)->with('responsible','courses')->get();
        $users_courses = User::where('type', 2)->with('responsibles.course', 'courses')
            ->has('responsibles')
            ->orderBy('id', 'asc')
            ->get();
        return view('admin.config', compact('users', 'courses', 'users_courses'));

    }
    public function configdb(Request $request)
    {

        $validatedData = $request->validate([
            'couse_id' => 'required',
            'user_id' => 'required',
        ]);
        //  dd($request);
        $id = IdGenerator::generate(['table' => 'responsibles', 'length' => 7, 'prefix' => date('ym'), 'reset_on_prefix_change' => true]);
        $data = [
            'id' => $id,
            'course_id' => $request->couse_id,
            'user_id' => $request->user_id,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),

            // Add more columns and values as needed
        ];

        $status_update = Responsible::insert($data);

        return redirect()->back()->with('status', 'Insert Successfully');

    }
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
        $coses = Course::where('delstatus', '<>', 1)
            ->get();
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
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
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

        $regists = Regist::whereNull('regists.std_status')
            ->join('projects', 'projects.id', '=', 'regists.project')
            ->join('courses', 'courses.id', '=', 'regists.course')
            ->join('users', 'users.id', '=', 'regists.iduser')
            ->select('regists.*', 'projects.Projectname as Projectname', 'courses.Cosename as Cosename', 'users.name as name', 'users.prefix as p')
            ->orderByDesc('id')->get();
            $regists1 = Regist::where('regists.std_status','=','1')
            ->join('projects', 'projects.id', '=', 'regists.project')
            ->join('courses', 'courses.id', '=', 'regists.course')
            ->join('users', 'users.id', '=', 'regists.iduser')
            ->select('regists.*', 'projects.Projectname as Projectname', 'courses.Cosename as Cosename', 'users.name as name', 'users.prefix as p')
            ->orderByDesc('id')->get();
            $regists2 = Regist::where('regists.std_status','=',2)
            ->join('projects', 'projects.id', '=', 'regists.project')
            ->join('courses', 'courses.id', '=', 'regists.course')
            ->join('users', 'users.id', '=', 'regists.iduser')
            ->select('regists.*', 'projects.Projectname as Projectname', 'courses.Cosename as Cosename', 'users.name as name', 'users.prefix as p')
            ->orderByDesc('id')->get();
            $regists3 = Regist::where('regists.std_status','=',3)
            ->join('projects', 'projects.id', '=', 'regists.project')
            ->join('courses', 'courses.id', '=', 'regists.course')
            ->join('users', 'users.id', '=', 'regists.iduser')
            ->select('regists.*', 'projects.Projectname as Projectname', 'courses.Cosename as Cosename', 'users.name as name', 'users.prefix as p')
            ->orderByDesc('id')->get();
            $regists4 = Regist::where('regists.std_status','=',4)
            ->join('projects', 'projects.id', '=', 'regists.project')
            ->join('courses', 'courses.id', '=', 'regists.course')
            ->join('users', 'users.id', '=', 'regists.iduser')
            ->select('regists.*', 'projects.Projectname as Projectname', 'courses.Cosename as Cosename', 'users.name as name', 'users.prefix as p')
            ->orderByDesc('id')->get();

        if ($search) {
            $regists->where('name', 'LIKE', '%' . $search . '%')
                ->orWhere('projects.Projectname', 'LIKE', '%' . $search . '%')
                ->orWhere('courses.Cosename', 'LIKE', '%' . $search . '%');
        }

        // Retrieve paginated data
        // $regists = $regists->paginate($perPage);
        // $regists = $regists->get();
        return view('admin.registdetail', compact('regists','regists1','regists2','regists3','regists4', 'search'));
    }
    public function upstatus(Request $request)
    {
        $regist = Regist::where('regists.id', $request->idreg)
            ->join('projects', 'projects.id', '=', 'regists.project')
            ->join('courses', 'courses.id', '=', 'regists.course')
            ->select('regists.*', 'projects.Projectname as project_name', 'courses.Cosename as course_name')
            ->first();
        $user = User::where('id', '=', $regist['iduser'])->first();

        $regist->update(
            [
                'std_status' => $request->updstatus,
            ]
        );
        switch ($request->updstatus) {
            case 2:
                $status = "ยื่นชำระเงินอีกครั้ง";
                break;
            case 3:
                $status = "ชำระเงินเรียบร้อยรอผลการสมัคร";
                break;
            case 4:
                $status = "<strong>ผ่านการคัดเลือก</strong> <br>" . $regist->project_name . "<br><strong>หลักสูตร</strong> " . $regist->course_name . "<br>คณะวิทยาศาสตร์และนวัตกรรมดิจิทัล มหาวิทยาลัยทักษิณ";
                break;
            default:
                //code block
        }

        $email = $user['email'];
        $name = $user['name'];
        $SendMailData = [
            'title' => 'แจ้งสถานะการสมัครเรียนผ่านระบบ Young Smart',
            'body' => 'เรียนคุณ' . $name . ' ได้สมัครเรียนผ่านระบบ Young Smart',

            'status' => ':: ' . $status . '',
            'URL' => 'ท่านสามารถตรวจสอบได้ทาง https://sc.scidi.tsu.ac.th/youngsmart ข้อมูลผู้สมัคร',

        ];

        Mail::to($email)->send(new SendMail($SendMailData));

        return redirect()->back()->with('status', 'Updated Successfully' . $user['id']);

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

    public function CouseUpstatus(Request $request)
    {
        Course::where('id', $request->id)
            ->update(
                [
                    'status' => $request->status,
                ]
            );
        return redirect()->back()->with('success', 'Updated Successfully');
    }

    public function viewregistsdetail(Request $request)
    {
        $regists = Regist::where('regists.id', '=', $request->id)
        //where('iduser','=',Auth::user()->id)
            ->join('projects', 'projects.id', '=', 'regists.project')
            ->join('courses', 'courses.id', '=', 'regists.course')
            ->join('users', 'users.id', '=', 'regists.iduser')
            ->select('regists.*', 'projects.Projectname as Projectname', 'courses.Cosename as Cosename', 'users.name as name', 'users.prefix as p', 'users.idcard as idcard', 'users.belong as belong', 'users.gread as gread', 'users.level as level', 'users.province as province', 'users.address as address', 'users.tel as tel', 'users.parent_tel as parent_tel', 'users.parent_name as parent_name')
            ->orderByDesc('regists.id')
            ->first();

        return view('admin.viewregistsdetail', compact('regists'));
    }
    public function deleteResponsible($id)
    {
        // Find the Responsible record by its id
        $responsible = Responsible::find($id);

        if ($responsible) {
            // Delete the record
            $responsible->delete();

            // Redirect or return a response
            return redirect()->route('admin.config')->with('success', 'Responsible deleted successfully');
        } else {
            return redirect()->route('admin.config')->with('error', 'Responsible not found');
        }
    }
    public function deleteRegist($id)
    {
        $regist = Regist::find($id);

        if ($regist) {
            // Delete the record
            $regist->delete();

            // Redirect or return a response
            return redirect()->route('admin.regist')->with('success', 'Regist deleted successfully');
        } else {
            return redirect()->route('admin.regist')->with('error', 'Regist not found');
        }
    }
    public function adduser_teacher()
    {
        $users = User::where('type', '=', 2)->get();
        return view('admin.adduser_teacher', compact('users'));
    }

    public function addusertadb(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],

        ]);

        User::create([

            'name' => $data['name'],
            'email' => $data['email'],
            'type' => 2,
            'password' => Hash::make($data['password']),
        ]);
        return redirect()->route('admin.adduser_teacher')->with('success', 'Add Teacher successfully');

    }

}
