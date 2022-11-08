<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use App\Exceptions\Handler;
use Throwable;
use App\Models\User;

class UsersController extends Controller
{
    public function __construct(User $user)
    {
        $this->table = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $users = $this->table->get();
            if(!$users)
                return response()->json(['status' => false, 'message' => 'Failed to get all users!', 'data' => null]);
        } catch (\Exception $ex) {
            \Log::info($ex);
            return response()->json(['status' => false, 'message' => $ex->getMessage()], 400);
        }
        return response()->json(['status' => true, 'message' => 'Successfuly get all users!', 'data' => $users]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name'      => 'required',
                'email'     => 'required|email',
                'password'  => 'required',
            ]);
    
            if ($validator->fails()) 
                return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);

            $find = $this->table->where("email", $request->email)->first();
            if($find) {
                return response()->json(['status' => false, 'message' => 'Failed to create user! Email has been registered to the system'], Response::HTTP_BAD_REQUEST);
            }else {
                $input              = $request->except('password');
                $input['password']  = Hash::make($request->password);
    
                $store = $this->table->store($input);
                if(!$store)
                    return response()->json(['status' => false, 'message' => 'Failed to create user!', 'data' => null]);
            }
        } catch (\Exception $ex) {
            \Log::info($ex);
            return response()->json(['status' => false, 'message' => $ex->getMessage()], 400);
        }
        return response()->json(['status' => true, 'message' => 'Successfuly create user!', 'data' => $store]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $find = $this->table->findOne($id);
            
            if(!$find)
                return response()->json(['status' => false, 'message' => 'Failed to find user!', 'data' => null]);
        } catch (\Exception $ex) {
            \Log::info($ex);
            return response()->json(['status' => false, 'message' => $ex->getMessage()], 400);
        }
        return response()->json(['status' => true, 'message' => 'Successfuly find user!', 'data' => $find]);
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
        try {
            $auth = $this->authorization($id, $this->table);
            if(!$auth)
                return response()->json(['status' => false, 'message' => 'You are not allowed to edit this user!', 'data' => null], 401);

            $update = $this->table->patch($request->all(), $id);
            
            if(!$update)
                return response()->json(['status' => false, 'message' => 'Failed to update user!', 'data' => null]);
        } catch (\Exception $ex) {
            \Log::info($ex);
            return response()->json(['status' => false, 'message' => $ex->getMessage()], 400);
        }
        return response()->json(['status' => true, 'message' => 'Successfuly update user!', 'data' => $update]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $auth = $this->authorization($id, $this->table);
            if(!$auth)
                return response()->json(['status' => false, 'message' => 'You are not allowed to delete this user!', 'data' => null], 401);

            $delete = $this->table->remove($id);
            if(!$delete)
                return response()->json(['status' => false, 'message' => 'Failed to delete user']);
        } catch (\Exception $ex) {
            \Log::info($ex);
            return response()->json(['status' => false, 'message' => $ex->getMessage()], 400);
        }
        return response()->json(['status' => true, 'message' => 'Successfuly delete user!']);
    }

    /**
     * Compare user id on post data and session data
     * 
     * @param  int  $id
     * @param \App\Model\Post
     * @return bool
     */
    private function authorization($id, $userTable) 
    {
        $user = $userTable->findOne($id);
        $user_data = json_decode(session()->get('user_data'));

        //Compare user in db and session
        if($user->id != $user_data->id)
            return false;

        return true;
    }
}
