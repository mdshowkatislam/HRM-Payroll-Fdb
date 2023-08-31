<?php

namespace App\Http\Controllers;

use App\Models\HrmClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class HrmClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = $request->all();
        $data = HrmClient::with('createdByName','updatedByName')
            ->where('status','Active');

        if (!empty($query)){
            $data = $this->filter($data,$query);
        }
        $data = $data->latest()->paginate(10);

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

    public function filter($data, $query)
    {

        if (array_key_exists('name',$query)){
            if ($query['name']){
                $data = $data->where('name','LIKE', '%' . $query['name'] . '%');
            }
        }
        if (array_key_exists('email',$query)){
            if ($query['email']){
                $data = $data->where('email','LIKE', '%' . $query['email'] . '%');
            }
        }
        if (array_key_exists('phone',$query)){
            if ($query['phone']){
                $data = $data->where('phone','LIKE', '%' . $query['phone'] . '%');
            }
        }
        if (array_key_exists('status',$query)){
            if ($query['status']){
                $data = $data->where('status','LIKE', '%' . $query['status'] . '%');
            }
        }

        if (array_key_exists('country',$query)){
            if ($query['country']){
                $data = $data->where('country','LIKE', '%' . $query['country'] . '%');
            }
        }

        if (array_key_exists('company',$query)){
            if ($query['company']){
                $data = $data->where('company','LIKE', '%' . $query['company'] . '%');
            }
        }

        if (array_key_exists('contact_person',$query)){
            if ($query['contact_person']){
                $data = $data->where('contact_person','LIKE', '%' . $query['contact_person'] . '%');
            }
        }

        if (array_key_exists('created_by',$query)){
            if ($query['created_by']){
                $data = $data->whereHas('createdByName', function($q) use($query){
                    $q->where('name','LIKE', '%' . $query['created_by'] . '%');
                });
            }
        }

        return $data;
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
        return response($request);
        $validator = Validator::make($request->all(), [
//            'serial' => 'required',
            'name' => 'required',
            'country' => 'required',
            'address' => 'required',
            'email' => 'required|string|email',
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

        if (HrmClient::create($request_data)){
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
     * @param  \App\Models\HrmClient  $hrmClient
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = HrmClient::find($id);

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
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HrmClient  $hrmClient
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = HrmClient::find($id);

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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HrmClient  $hrmClient
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
//            'serial' => 'required',
            'name' => 'required',
            'country' => 'required',
            'address' => 'required',
            'email' => 'required|string|email',
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

        $data = HrmClient::find($id);

        if (!empty($data)){
            $request_data = $request->all();
            $request_data['updated_by'] = Auth::id();

            if ($data->update($request_data)){
                $response['status'] = 'success';
                $response['message'] = 'Data updated successfully.';
                return response($response, 200);

            }else{
                $response['status'] = 'error';
                $response['message'] = 'Something went to wrong!';
                return response($response, 422);
            }

        }else{
            $response['status'] = 'error';
            $response['message'] = 'Data not found.';
            return response($response, 422);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HrmClient  $hrmClient
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = HrmClient::find($id);

        if (!empty($data)){

            if ($data->delete()){
                $response['status'] = 'success';
                $response['message'] = 'Data deleted successfully.';
                return response($response, 200);

            }else{
                $response['status'] = 'error';
                $response['message'] = 'Something went to wrong!';
                return response($response, 422);
            }

        }else{
            $response['status'] = 'error';
            $response['message'] = 'Data not found.';
            return response($response, 422);
        }
    }
}
