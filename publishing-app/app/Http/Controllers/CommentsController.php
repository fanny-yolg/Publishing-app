<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use App\Models\Comment;
use App\Exceptions\Handler;
use Throwable;

class CommentsController extends Controller
{
    public function __construct(Comment $comment)
    {
        $this->table = $comment;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $comments = $this->table->get();
            if(!$comments)
                return response()->json(['status' => false, 'message' => 'Failed to get all comments!', 'data' => null]);
        } catch (\Exception $ex) {
            \Log::info($ex);
            return response()->json(['status' => false, 'message' => $ex->getMessage()], 400);
        }
        return response()->json(['status' => true, 'message' => 'Successfuly get all comments!', 'data' => $comments]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'content' => 'required',
                'post_id' => 'required',
            ]);
    
            if ($validator->fails()) 
                return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
            
            $user_data = json_decode(session()->get('user_data'));

            $data_to_store = $request->all();
            $data_to_store['user_id'] = $user_data->id;

            $store = $this->table->store($data_to_store);
            if(!$store)
                return response()->json(['status' => false, 'message' => 'Failed to post comment!', 'data' => null]);
        } catch (\Exception $ex) {
            \Log::info($ex);
            return response()->json(['status' => false, 'message' => $ex->getMessage()], 400);
        }
        return response()->json(['status' => true, 'message' => 'Successfuly post comment!', 'data' => $store]);
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
                return response()->json(['status' => false, 'message' => 'Failed to find comment!', 'data' => null]);
        } catch (\Exception $ex) {
            \Log::info($ex);
            return response()->json(['status' => false, 'message' => $ex->getMessage()], 400);
        }
        return response()->json(['status' => true, 'message' => 'Successfuly find comment!', 'data' => $find]);
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
                return response()->json(['status' => false, 'message' => 'You are not allowed to update this delete!', 'data' => null], 401);

            $update = $this->table->patch($request->all(), $id);
            
            if(!$update)
                return response()->json(['status' => false, 'message' => 'Failed to update comment!', 'data' => null]);
        } catch (\Exception $ex) {
            \Log::info($ex);
            return response()->json(['status' => false, 'message' => $ex->getMessage()], 400);
        }
        return response()->json(['status' => true, 'message' => 'Successfuly update comment!', 'data' => $update]);
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
                return response()->json(['status' => false, 'message' => 'You are not allowed to delete this comment!', 'data' => null], 401);
            
            $delete = $this->table->remove($id);
            if(!$delete)
                return response()->json(['status' => false, 'message' => 'Failed to delete comment']);
        } catch (\Exception $ex) {
            \Log::info($ex);
            return response()->json(['status' => false, 'message' => $ex->getMessage()], 400);
        }
        return response()->json(['status' => true, 'message' => 'Successfuly delete comment!']);
    }

    /**
     * Compare user id on post data and session data
     * @param  int  $id
     * @param \App\Model\Post
     * @return bool
     */
    private function authorization($id, $commentTable) 
    {
        $comment = $commentTable->findOne($id);
        $user_data = json_decode(session()->get('user_data'));

        //Compare user in db and session
        if($comment->user_id != $user_data->id)
            return false;

        return true;
    }
}
