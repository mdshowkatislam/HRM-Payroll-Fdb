<?php

namespace App\Http\Controllers;

use App\Models\HrmClient;
use App\Models\ProjectPermission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProjectPermissionController extends Controller
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
     * Get Key access manager for project permission
     */
    public function get_kam()
    {
        $data = User::whereHas('role', function($q) {
                $q->where('name','KAM');
            })->where('status','Active')->get();

        if ($data){
            $response['status'] = 'success';
            $response['message'] = 'Data found.';
            $response['response_data'] = $data;
            return response($response, 200);

        }else{
            $response['status'] = 'error';
            $response['message'] = 'Data not found.';
            return response($response, 422);
        }
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
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'project_id' => 'required',
        ]);

        if ($validator->fails())
        {
            $response =[
                "status" => "error",
                "message" => "Something went to wrong!",
                'errors'=>$validator->errors()->all()
            ];
            return response($response, 401);
        }

        $request_data = $request->all();
        $request_data['created_by'] = Auth::id();

        if (ProjectPermission::create($request_data)){
            $response['status'] = 'success';
            $response['message'] = 'Data inserted successfully.';
            return response($response, 201);

        }else{
            $response['status'] = 'error';
            $response['message'] = 'Something went to wrong!';
            return response($response, 422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProjectPermission  $projectPermission
     * @return \Illuminate\Http\Response
     */
    public function show(ProjectPermission $projectPermission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProjectPermission  $projectPermission
     * @return \Illuminate\Http\Response
     */
    public function edit(ProjectPermission $projectPermission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProjectPermission  $projectPermission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProjectPermission $projectPermission)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProjectPermission  $projectPermission
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProjectPermission $projectPermission)
    {
        //
    }
}
