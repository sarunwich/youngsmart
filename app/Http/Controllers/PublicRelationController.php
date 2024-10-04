<?php

namespace App\Http\Controllers;

use App\Models\PublicRelation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Haruncpi\LaravelIdGenerator\IdGenerator;


class PublicRelationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $news=PublicRelation::all();
        return view('admin.adminNews', compact('news'));

    }
    public function addnew(Request $request)
    {
        $id = IdGenerator::generate(['table' => 'public_relations', 'length' => 7, 'prefix' => date('ym'), 'reset_on_prefix_change' => true]);
         $validatedData = $request->validate([

            'pr_title' => 'required',
            'pr_detail' => 'required',
            // 'pr_file' => 'required|mimes:pdf,docx,doc|max:2048',
         ]);
        $uid = Auth::user()->id;
        $name=null;
        if ($request->hasfile('pr_file')) {

            $filename = $request->file('pr_file')->getClientOriginalName();
            $filename = explode(".", $filename);
            $name = "PR_" . $filename[0] . "_" . time() . rand(1, 100) . '.' . $request->pr_file->extension();
            $request->pr_file->storeAs('public/pr_file', $name);
           

           

        }
        $data = [
            'id'=>$id,
            'pr_title' => $request->pr_title,
            'pr_detail' => $request->pr_detail,
            'pr_date' => date('Y-m-d H:i:s'),
            'pr_file' => $name,
            'pr_staus' => 1,
            'id_admin' => $uid,
            // Add more columns and values as needed
        ];
        $status_update = PublicRelation::insert([
            'id'=>$id,
            'pr_title' => $request->pr_title,
            'pr_detail' => $request->pr_detail,
            'pr_date' => date('Y-m-d H:i:s'),
            'pr_file' => $name,
            'pr_staus' => 1,
            'id_admin' => $uid,
        ]);
        
        // PublicRelation::create($data);
        
        // Alternatively, you can use the new instance directly
        // $model = new PublicRelations($data);
        // $model->save();

        return redirect()->back();
    }
    public function PrUpstatus(Request $request)
    {
        $id = $request->id;
        $intValue = intval($request->status);
        DB::table('public_relations')
            ->where('id', $id)
            ->update(['pr_staus' => $intValue]);
            return response()->json(['success' => 'Data is update']);
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
     * @param  \App\Models\PublicRelation  $publicRelation
     * @return \Illuminate\Http\Response
     */
    public function show(PublicRelation $publicRelation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PublicRelation  $publicRelation
     * @return \Illuminate\Http\Response
     */
    public function edit(PublicRelation $publicRelation)
    {
        //
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PublicRelation  $publicRelation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $PublicRelation=PublicRelation::find($id);
        $PublicRelation->pr_title = $request->input('pr_title');
        $PublicRelation->pr_detail = $request->input('pr_detail');
        $PublicRelation->save();

        return redirect()->back()->with('success', 'Updated successfully');
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PublicRelation  $publicRelation
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $data = PublicRelation::findOrFail($id);

        // Delete the data
        $data->delete();

        // Redirect or show a success message
        return redirect()->back()->with('success', 'Data deleted successfully!');
    }
}
