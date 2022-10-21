<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use Illuminate\Http\Request;
use App\Services\CategoryService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CategoryController extends Controller
{
    private $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;

        $this->middleware('check.admin',
            ['only' => ['store','update','destroy']]
        );

        /**/

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $categories = $this->categoryService->viewAll();
            $response = array(
                'status'    => 'success',
                'data'      => $categories,
                'message'   => ''
            );

            if($categories->count() == 0){
                return response()->json($response, 404);
            }else{
                return response()->json($response, 200);
            }

        }catch(\Exception $exception){
            $response = array(
                'status'    => 'Error',
                'message'   => 'server error',
            );
            return response()->json($response, 500);
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
        try{
            $validator = Validator::make($request->all(), [
                'category' => 'required',
            ]);

            if($validator->fails()){
                throw new ValidationException($validator);
            }

            $insertedRecord = $this->categoryService->add($request->get('category'));

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

            $category = $this->categoryService->view($id);

            if($category){
                $response = array(
                    'status'    => 'Success',
                    'data'      => $category,
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
        //var_dump($request->get('category'));
        //dd();
        try{

            if(is_numeric ($id)){
                $id = intval($id);
            }else{
                throw new \Exception('The given data was invalid',400);
            }

            $validator = Validator::make($request->all(), [
                'category'  => 'required',
            ]);

            if($validator->fails()){
                throw new ValidationException($validator);
            }

            $updatedRecord = $this->categoryService->update($request->get('category'),$id);

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

            $this->categoryService->delete($id);

            /*
            $response = array(
                'status'    => 'Success',
                'data'      => '',
                'message'   => 'category deleted successfully'
            );
            */
            $response = null;
            return response()->json($response, 204);


        }catch (\Exception $e) {

            $response = array(
                'status'    => 'Error',
                'message'   => 'Internal server error',
            );
            return response()->json($response, 500);
        }

    }

    public function threadsBelongToCategory($id)
    {
        try{
            if(is_numeric ($id)){
                $id = intval($id);
            }else{
                throw new \Exception('The given data was invalid',400);
            }

            $threadsData = $this->categoryService->getThreadsBelongToCategory($id);

            $response = array(
                'status'    => 'Success',
                'message'   => '',
                'data'      => $threadsData,
            );
            return response()->json($response, 200);

        }catch (CustomException $e) {

            $response = array(
                'status'    => 'Error',
                'message'   => $e->getMessage(),
                'data'      => [],
            );
            return response()->json($response, $e->getCode());
        }catch (\Exception $e) {

            $response = array(
                'status'    => 'Error',
                'data'      => [],
                //'message'   => 'Internal server error',
                'message'   => $e->getMessage(),
            );
            return response()->json($response, 500);
        }

        // dd('threadsBelongToCategory - '.$id);
        //category/5/threads    --> threadcategories[]

    }

}
