<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Services\PostService;

class PostController extends Controller
{

    private $postService;

    public function __construct(PostService $postService){
        $this->postService = $postService;
        /*
        $this->middleware('check.login',
            ['only' => ['store']]
        );

        //owner - update destroy with time limit
        //admin - update destroy
        $this->middleware('modify.posts',
            ['only' => ['update','destroy']]
        );
        */
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'text'       => 'required',
                'thread_id'  => 'required',
                'user_id'    => 'required',
            ]);

            if($validator->fails()){
                throw new ValidationException($validator);
            }

            $text           = $request->get('text');
            $userId         = $request->get('user_id');
            $threadId       = $request->get('thread_id');

            $insertedRecord = $this->postService->add($text,$userId,$threadId);

            $response = array(
                'status'    => 'Success',
                'data'      => $insertedRecord,
                'message'   => 'Post added successfully'
            );

            return response()->json($response, 201);

        }catch (ValidationException $exception) {

            $response = array(
                'status'    => 'Error',
                'message'   => $exception->getMessage(),
            );
            return response()->json($response, 400);
        }catch(CustomException $exception){

            $response = array(
                'status'    => 'Error',
                'message'   => $exception->getMessage(),
            );
            return response()->json($response, $exception->getCode());
        }catch(\Exception $exception){

            $response = array(
                'status'    => 'Error',
                'message'   => 'Internal server error',
            );
            return response()->json($response, 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        try{

            if(is_numeric ($id)){
                $id = intval($id);
            }else{
                throw new \Exception('The given data was invalid',400);
            }

            $post = $this->postService->view($id);

            //dd($post);
            if($post){
                $response = array(
                    'status'    => 'Success',
                    'data'      => $post,
                    'message'   => ''
                );
                return response()->json($response, 200);
            }else{
                $response = array(
                    'status'    => 'Error',
                    'data'      => null,
                    'message'   => 'Resource does not exist'
                );
                return response()->json($response, 404);
            }

        }catch(CustomException $exception){

            $response = array(
                'status'    => 'Error',
                'message'   => $exception->getMessage(),
            );
            return response()->json($response, $exception->getCode());
        }catch (\Exception $e) {

            $response = array(
                'status'    => 'error',
                'message'   => 'Internal server error',
                //'message'   => $e->getMessage(),
            );
            return response()->json($response, 500);
        }
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
        try{

            if(is_numeric ($id)){
                $id = intval($id);
            }else{
                throw new \Exception('The given data was invalid',400);
            }

            $validator = Validator::make($request->all(), [
                'text'       => 'required',
                'thread_id'  => 'required',
                'user_id'    => 'required',
                'is_useful'  => 'required',
            ]);
            //var_dump($validator->errors ());
            //dd();
            if($validator->fails()){
                throw new ValidationException($validator);
            }

            $text           = $request->get('text');
            $userId         = $request->get('user_id');
            $threadId       = $request->get('thread_id');
            $isUseful        = $request->get('is_useful');

            $updatedRecord = $this->postService->update($text,$userId,$threadId,$isUseful,$id);

            $response = array(
                'status'    => 'Success',
                'data'      => $updatedRecord,
                'message'   => 'Post updated successfully'
            );

            return response()->json($response, 201);

        }catch (ValidationException $exception) {

            $response = array(
                'status'    => 'Error',
                'message'   => $exception->getMessage(),
            );
            return response()->json($response, 400);
        }catch(CustomException $exception){

            $response = array(
                'status'    => 'Error',
                'message'   => $exception->getMessage(),
            );
            return response()->json($response, $exception->getCode());
        }catch(\Exception $exception){

            $response = array(
                'status'    => 'Error',
                'message'   => 'Internal server error',
                //'message'   => $exception->getMessage(),
            );
            return response()->json($response, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{

            if(is_numeric ($id)){
                $id = intval($id);
            }else{
                throw new CustomException('The given data was invalid',400);
            }

            $this->postService->delete($id);

            /*
            $response = array(
                'status'    => 'success',
                'data'      => '',
                'message'   => 'category deleted successfully'
            );
            */
            $response = null;
            return response()->json($response, 204);


        }catch (CustomException $e) {

            $response = array(
                'status'    => 'error',
                'message'   => $e->getMessage(),
            );
            return response()->json($response, $e->getCode());
        }catch (\Exception $e) {

            $response = array(
                'status'    => 'error',
                'message'   => 'Internal server error',
            );
            return response()->json($response, 500);
        }
    }
}
