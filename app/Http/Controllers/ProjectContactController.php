<?php

namespace App\Http\Controllers;

use App\Models\HrmClient;
use App\Models\Project;
use App\Models\ProjectContact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
 use Illuminate\Support\Str;
 use Illuminate\Support\Facades\DB;


class ProjectContactController extends Controller
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
     * get clients for create project.
     */

    public function project_client(){

        $data = HrmClient::where('status','Active');
        $data = $data->latest()->get();

        if (!empty($data)){
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return response($request->all());

        $validator = Validator::make($request->all(), [
//            'serial' => 'required',
            'hrm_client_id' => 'required',
            'name' => 'required',
            'description' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
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
        // return response( count($request_data['contact']));

        $max_id = Project::max('id');
        if($max_id){
            $max_id =$max_id+1;
        }else{
            $max_id=1;
        }
        // $random = Str::random(3);
        // str_random(32)
        $project_fdb_id = 'FDB-PR-' .random_int(100, 999) .$max_id;

        $request_data['created_by'] = Auth::id();
        $request_data['project_fdb_id'] = $project_fdb_id;



        // return response( $request_contact_data);
        // return response( $request_data);

        $project_id = Project::insertGetId([
            'hrm_client_id' =>$request_data['hrm_client_id'],
            'name' => $request_data['name'],
            'project_fdb_id' => $request_data['project_fdb_id'],
            'description' => $request_data['description'],
            'start_date' => $request_data['start_date'],
            'end_date' => $request_data['end_date'],
            'status' => $request_data['status'],
            'created_by' => $request_data['created_by'],


        ]);

        $contact_project = [];
        for($i= 0; $i < count($request_data['contact']); $i++){
            $contact_project[] = [

              'name' => $request_data['contact'][$i]['name'],
              'project_id' => $project_id,
              'email' => $request_data['contact'][$i]['email'],
              'phone' => $request_data['contact'][$i]['phone'],
              'image'=> $request_data['contact'][$i]['image'],
              'designation' => $request_data['contact'][$i]['designation'],
              'country' => $request_data['contact'][$i]['country'],
              'address' => $request_data['contact'][$i]['address'],
              'website' => $request_data['contact'][$i]['website'],
              'status'  =>$request_data['contact'][$i]['status'],
              'created_by'  =>$request_data['created_by']

            ];
            ProjectContact::insert($contact_project);

        }

        //  return response($contact_project);


        if ($contact_project){

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
     * @param  \App\Models\ProjectContact  $projectContact
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

         $user_id=Auth::check()? Auth::id():true;

        $all_project=DB::table('projects')->where('id',$user_id)->get();
        return response($all_project);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProjectContact  $projectContact
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
return response($request);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProjectContact  $projectContact
     * @return \Illuminate\Http\Response
     */



     public function destroy($id)
    {
        $project_id=DB::table('projects')->where('id',$id);

        if($project_id){
            try{
                DB::table('project_contacts')->where('project_id',$id)->delete() ;
                DB::table('projects')->where('id', $id)->delete();

                $response['status'] = 'success';
                $response['message'] = 'Data deleted successfully.';
                return response($response, 201);
            } catch(\Exception $e){
                $response['status'] = 'error';
                      $response['message'] = 'Something went to wrong!';
                      return response($response, 422);
            }
        }else{
            $response['status'] = 'error';
                      $response['message'] = 'Something went to wrong!';
                      return response($response, 422);

        }


   }
}

