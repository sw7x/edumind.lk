<?php

namespace App\Http\Controllers;


use App\Exceptions\CustomException;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
        /*
        $this->middleware('check.login',
            ['only' => ['index']]
        );
        $this->middleware('check.admin',
            ['only' => ['update','show']]
        );
        */
    }

    public function show($id){

        try{

            if(is_numeric ($id)){
                $id = intval($id);
            }else{
                throw new \Exception('The given data was invalid',400);
            }
            $user = $this->userService->view($id);

            if($user){
                $response = array(
                    'status'    => 'Success',
                    'data'      => $user,
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
                'status'    => 'error',
                'message'   => $e->getMessage(),
            );
            return response()->json($response, $e->getCode());
        }catch (\Exception $e) {

            $response = array(
                'status'    => 'error',
                //'message'   => 'Internal server error',
                'message'   => $e->getMessage(),
            );
            return response()->json($response, 500);
        }
    }


    public function update(Request $request,$id){

        try{
            if(is_numeric ($id)){
                $id = intval($id);
            }else{
                throw new \Exception('The given data was invalid',400);
            }

            $validator = Validator::make($request->all(), [
                'badge'         => 'required',
                'points'        => 'required',
                'account_type'  => 'required',
            ]);


            if($validator->fails()){
                throw new ValidationException($validator);
            }

            $userDetailsArr = array(
                'badge'          => $request->get('badge'),
                'points'         => $request->get('points'),
                'account_type'   => $request->get('account_type'),
            );

            $updatedRecord = $this->userService->update($userDetailsArr,$id);

            $response = array(
                'status'    => 'Success',
                'data'      => $updatedRecord,
                'message'   => 'User updated successfully'
            );

            return response()->json($response, 200);

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

    public function index(){
        try{

            $users = $this->userService->viewAll();
            if($users){
                $response = array(
                    'status'    => 'Success',
                    'data'      => $users,
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
                'status'    => 'error',
                'message'   => $e->getMessage(),
            );
            return response()->json($response, $e->getCode());
        }catch (\Exception $e) {

            $response = array(
                'status'    => 'error',
                //'message'   => 'Internal server error',
                'message'   => $e->getMessage(),
            );
            return response()->json($response, 500);
        }
    }

    public function getUserRole($userId){
        $usersRole = $this->userService->getUserRole($userId);

        if($usersRole){
            $response = array(
                'status'    => 'Success',
                'data'      => array('user_role' => $usersRole),
                'message'   => ''
            );
            return response()->json($response, 200);
        }else{
            $response = array(
                'status'    => 'Error',
                'data'      => null,
                'message'   => 'User does not exist'
            );
            return response()->json($response, 400);
        }
    }






}
