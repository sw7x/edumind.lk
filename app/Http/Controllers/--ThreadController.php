<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use App\Models\Thread;
use App\Services\ThreadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Symfony\Component\Console\Input\Input;

class ThreadController extends Controller
{
     private $threadService;

    public function __construct(ThreadService $threadService)
    {
        $this->threadService = $threadService;;
        /*
        $this->middleware('check.login',
            ['only' => ['store','threadSearch']]
        );

        //owner - update destroy with time limit
        //admin - update destroy
        $this->middleware('modify.threads',
            ['only' => ['update','destroy']]
        );
        */

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $threadInfo = $this->threadService->viewAll();
            $response = array(
                'status'    => 'Success',
                'data'      => $threadInfo,
                'message'   => ''
            );

            if(empty($threadInfo)){
                return response()->json($response, 404);
            }else{
                return response()->json($response, 200);
            }

        }catch(\Exception $exception){
            $response = array(
                'status'    => 'Error',
                'message'   => 'server error',
            );
            //return response()->json($response, 500);
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
        //dd($request->get('category'));
        try{
            $validator = Validator::make($request->all(), [
                'title' => 'required',
                'text' => 'required',
                'category' => 'required',
                'userId' => 'required|integer',
            ]);

            if($validator->fails()){
                throw new ValidationException($validator);
            }

            $title      = $request->get('title');
            $text       = $request->get('text');
            $userId     = $request->get('userId');
            $categoryArr    = $request->get('category');

            $insertedRecord = $this->threadService->add($title,$text,$userId,$categoryArr);

            $response = array(
                'status'    => 'Success',
                'data'      => $insertedRecord,
                'message'   => 'category added successfully'
            );

            return response()->json($response, 201);

        }catch (ValidationException $exception) {
            $response = array(
                'status'    => 'Error',
                'message'   => $exception->getMessage(),
            );
            return response()->json($response, 400);

        }catch(\Exception $exception){
            $exceptionCode = ($exception->getCode()==0)?500:$exception->getCode();
            $message = $exception->getMessage();
            //$message = 'server error';
            $response = array(
                'status'    => 'Error',
                'message'   => $message,
            );
            return response()->json($response, $exceptionCode);
        }

    }

    /**
     * Display the specified resource.
     *
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

            $thread = $this->threadService->view($id);

            if($thread){
                $response = array(
                    'status'    => 'Success',
                    'data'      => $thread,
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

        }catch (CustomException $e) {

            $response = array(
                'status'    => 'Error',
                'message'   => $e->getMessage(),
            );
            return response()->json($response, $e->getCode());
        }catch (\Exception $e) {

            $response = array(
                'status'    => 'Error',
                'message'   => 'Internal server error',
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
                'title' => 'required',
                'text' => 'required',
                'category' => 'required',
                'userId' => 'required',
            ]);

            if($validator->fails()){
                throw new ValidationException($validator);
            }

            $title      = $request->get('title');
            $text       = $request->get('text');
            $userId     = $request->get('userId');
            $categoryArr    = $request->get('category');

            $updatedRecord = $this->threadService->update($title,$text,$userId,$categoryArr,$id);


            $response = array(
                'status'    => 'Success',
                'data'      => $updatedRecord,
                'message'   => 'category updated successfully'
            );

            return response()->json($response, 200);

        }catch (ValidationException $exception) {
            $response = array(
                'status'    => 'Error',
                'message'   => $exception->getMessage(),
            );
            return response()->json($response, 400);
        }catch(\Exception $exception){
            $exceptionCode = ($exception->getCode()==0)?500:$exception->getCode();
            $message = $exception->getMessage();
            //$message = 'server error';
            $response = array(
                'status'    => 'Error',
                'message'   => $message,
            );
            return response()->json($response, $exceptionCode);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{

            if(is_numeric ($id)){
                $id = intval($id);
            }else{
                throw new \Exception('The given data was invalid',400);
            }

            $this->threadService->delete($id);
            $response = null;
            return response()->json($response, 204);


        }catch (\Exception $e) {

            $response = array(
                'status'    => 'Error',
                'message'   => 'Internal server error',
                //'message'   => $e->getMessage(),
            );
            return response()->json($response, 500);
        }

    }

    public function getThreadPosts($id){

        try{
            if(is_numeric ($id)){
                $id = intval($id);
            }else{
                throw new \Exception('The given data was invalid',400);
            }

            $threadPosts = $this->threadService->getThreadPosts($id);
            $response = array(
                'status'    => 'Success',
                'data' => $threadPosts,
                'message'   => '',
            );


            return response()->json($response, 200);

        }catch (CustomException $e) {

            $response = array(
                'status'    => 'Error',
                'message'   => $e->getMessage(),
            );
            return response()->json($response, $e->getCode());
        }catch (\Exception $e) {

            $response = array(
                'status'    => 'Error',
                //'message'   => 'Internal server error',
                'message'   => $e->getMessage(),
            );
            return response()->json($response, 500);
        }


    }

    public function threadSearch(Request $request){

        try{
            if($request->has('q')){
                $threadTitle = $request->get('q');

                if($threadTitle == null){
                    throw new CustomException('Invalid Search query',400);
                }else{
                    $searchedThreads = $this->threadService->threadSearch($threadTitle);

                    if(empty($searchedThreads)){
                        $response = array(
                            'status'    => 'Success',
                            'data'      => $searchedThreads,
                            'message'   => 'No Results Found'
                        );
                        return response()->json($response, 204);
                    }else{
                        $response = array(
                            'status'    => 'Success',
                            'data'      => $searchedThreads,
                            'message'   => ''
                        );
                        return response()->json($response, 200);
                    }
                }
            }else{
                throw new CustomException('Invalid Search query',400);
            }
        }catch (CustomException $e) {

            $response = array(
                'status'    => 'Error',
                'message'   => $e->getMessage(),
            );
            return response()->json($response, $e->getCode());
        }catch (\Exception $e) {

            $response = array(
                'status'    => 'Error',
                //'message'   => 'Internal server error',
                'message'   => $e->getMessage(),
            );
            return response()->json($response, 500);
        }


    }



}
