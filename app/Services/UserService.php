<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Sentinel;
use App\Exceptions\CustomException;
use App\Models\User as UserModel;
use App\DataTransformers\Database\UserDataTransformer;


class UserService
{  

    private UserRepository $userRepository;

    function __construct(UserRepository $userRepository){
        $this->userRepository = $userRepository;
    }
    

    public function findDbRec(int $id) : array {
        $dbRec  =   $this->userRepository->findById($id);
        if(is_null($dbRec))
            abort(404,'User not found');
        
        $dto    =   $dbRec ? UserDataTransformer::buildDto($dbRec->toArray()) : null;        
        return array(
            'dbRec' => $dbRec,
            'dto'   => $dto
        );
    }




    /*    
    public function loadLoggedInUserData() : array {
        $user = Sentinel::getUser();
        if(is_null($user))
            throw new CustomException('Access denied');

        return array(
            'dto'   =>  UserDataTransformer::buildDto($user->toArray()),
            'dbRec' =>  $user,
        );
    }    

    public function loadUserData() : array {
        $user = Sentinel::getUser();
        if(is_null($user))
            throw new CustomException('Access denied');

        return array(
            'dto'   =>  UserDataTransformer::buildDto($user->toArray()),
            'dbRec' =>  $user,
        );
    }

    

    private $userRepository;

    public function __construct(UserRepository $userRepository) {
        $this->userRepository  = $userRepository;
    }

    public function view($id){

        $user = $this->userRepository->findUserById($id);

        if(!$user){
            throw new CustomException('Resource does not exist',404);
        }else{
             return array(
                 'id'             => $user->id,
                 'fullname'       => $user->fullname,
                 'email'          => $user->email,
                 'username'       => $user->username,
                 'gender'         => $user->gender,
                 'badge'          => $user->badge,
                 'points'         => $user->points,
                 'account_type'   => $user->role->role_name
             );
        }
    }

    public function viewAll(){

        $users = $this->userRepository->findAll();


        if($users->count ()==0){
            throw new CustomException('Resource does not exist',404);
        }else{

            $arr = array();
            foreach($users as $user){
                $arr[] = array(
                            'id'             => $user->id,
                            'fullname'       => $user->fullname,
                            'email'          => $user->email,
                            'username'       => $user->username,
                            'gender'         => $user->gender,
                            'badge'          => $user->badge,
                            'points'         => $user->points,
                            'account_type'   => $user->role->role_name
                        );
            }
            return $arr;
        }
    }

    public function update($userDetailsArr,$id){
        $selectedUser = $this->userRepository->findUserById($id);

        if($selectedUser==null){
            throw new \Exception('Resource does not exist',404);
        }else{

            $updateResult = $this->userRepository->updateById($userDetailsArr,$id);
            if($updateResult['isUpdated']){
                return array([
                    'id'             => $id,
                    'fullname'       => $selectedUser->fullname,
                    'email'          => $selectedUser->email,
                    'username'       => $selectedUser->username,
                    'gender'         => $selectedUser->gender,
                    'badge'          => $userDetailsArr['badge'],
                    'points'         => $userDetailsArr['points'],
                    'account_type'   => $userDetailsArr['account_type']
                ]);
            }else{
                throw new \PDOException('Failed to insert into database',500);
            }
        }
    }

    public function changePw($pass,$userId,$oldPass){
        $user = $this->userRepository->findUserById($userId);
        if(empty($user)){
            throw new CustomException('User does not exist',400);
        }
        if($user->password == $oldPass){
            $isUpdated = $this->userRepository->updateUserPass($user,$pass);
        }else{
            throw new CustomException('Old password do not match with database record',400);
        }

        if(!$isUpdated){
            throw new CustomException('Internal Server Error',500);
        }
    }

    public function getUserRole($userId){
        $user = $this->userRepository->findUserById($userId);
        if(empty($user)){
            return false;
        }else{
            return $user->role->role_name;
        }
    }


    public function checkUsernameExists($username){
        return User::withoutGlobalScope('active')->where('username',$username)->get()->count();
    }

    public function generateUniqueUsername($username){

        $username = cleanUsernameString($username);
        if(strlen($username)>15){
            $username = substr($username, 0, 15);
        }

        $uname = $username;

        do {
            if($this->checkUsernameExists($uname) == 0){
                $x = 0;
            }else{
                $uname = $username.rand(1000,9999);
                //$uname = $username.rand(1,9);
                $x = 1;
            }
            //var_dump ($uname);
            //var_dump ($x);
        } while ($x == 1);
        return $uname;
    }
    */
}




//service only methods - not in entity    
    //view all teachers
    //view all stu
    //view all marketers
    //view all editors
    //add 
    //edit
    //delete
    //view use Single(teachers,stu,marketers,editors)
    


//service methods - also in entity   
    //change user status

