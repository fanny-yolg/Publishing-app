<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use App\Models\Post;
use App\Exceptions\Handler;
use Throwable;

class PostsController extends Controller
{
    public function __construct(Post $post)
    {
        $this->table = $post;
    }
    
    /**
     * Get list of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $posts = $this->table->get();
            if(!$posts)
                return response()->json(['status' => false, 'message' => 'Failed to get all posts!', 'data' => null]);
        } catch (\Exception $ex) {
            \Log::info($ex);
            return response()->json(['status' => false, 'message' => $ex->getMessage()], 400);
        }
        return response()->json(['status' => true, 'message' => 'Successfuly get all posts!', 'data' => $posts]);
    }

    /**
     * Get list of the resource with comments.
     *
     * @return \Illuminate\Http\Response
     */
    public function GetPostList($with_comments = false)
    {
        try{
            if($with_comments) {
                $posts = $this->table->with('comments')->get();
            }else{
                $posts = $this->table->get();
            }

            if(!$posts)
                return response()->json(['status' => false, 'message' => 'Failed to get all posts!', 'data' => null]);
        } catch (\Exception $ex) {
            \Log::info($ex);
            return response()->json(['status' => false, 'message' => $ex->getMessage()], 400);
        }
        return response()->json(['status' => true, 'message' => 'Successfuly get all posts!', 'data' => $posts]);
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
                'title'     => 'required',
                'body'      => 'required',
            ]);
    
            if ($validator->fails()) 
                return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
            
            $user_data = json_decode(session()->get('user_data'));
            $data_to_store = $request->all();
            $data_to_store['user_id'] = $user_data->id;

            $store = $this->table->store($data_to_store);
            if(!$store)
                return response()->json(['status' => false, 'message' => 'Failed to create post!', 'data' => null]);
        } catch (\Exception $ex) {
            \Log::info($ex);
            return response()->json(['status' => false, 'message' => $ex->getMessage()], 400);
        }
        return response()->json(['status' => true, 'message' => 'Successfuly create post!', 'data' => $store]);
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
                return response()->json(['status' => false, 'message' => 'Failed to find post!', 'data' => null]);
        } catch (\Exception $ex) {
            \Log::info($ex);
            return response()->json(['status' => false, 'message' => $ex->getMessage()], 400);
        }
        return response()->json(['status' => true, 'message' => 'Successfuly find post!', 'data' => $find]);
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
                return response()->json(['status' => false, 'message' => 'You are not allowed to update this post!', 'data' => null], 401);

            $update = $this->table->patch($request->all(), $id);
            
            if(!$update)
                return response()->json(['status' => false, 'message' => 'Failed to update post!', 'data' => null]);
        } catch (\Exception $ex) {
            \Log::info($ex);
            return response()->json(['status' => false, 'message' => $ex->getMessage()], 400);
        }
        return response()->json(['status' => true, 'message' => 'Successfuly update post!', 'data' => $update]);
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
                return response()->json(['status' => false, 'message' => 'You are not allowed to delete this post!', 'data' => null], 401);

            $delete = $this->table->remove($id);
            if(!$delete)
                return response()->json(['status' => false, 'message' => 'Failed to delete post']);
        } catch (\Exception $ex) {
            \Log::info($ex);
            return response()->json(['status' => false, 'message' => $ex->getMessage()], 400);
        }
        return response()->json(['status' => true, 'message' => 'Successfuly delete post!']);
    }

    /**
     * Compare user id on post data and session data
     *
     * @param  int  $id
     * @param \App\Model\Post
     * @return bool
     */
    private function authorization($id, $postTable) 
    {
        $post = $postTable->findOne($id);
        $user_data = json_decode(session()->get('user_data'));

        //Compare user in db and session 
        if($post->user_id != $user_data->id)
            return false;

        return true;
    }
}
