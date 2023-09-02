<?php
namespace App\Repositories;


use App\Repositories\BaseRepository;

use App\Models\User as UserModel;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\Interfaces\IGetDtoDataRepository;
use App\Mappers\UserMapper;

class UserRepository extends BaseRepository implements IGetDtoDataRepository{
    
    public function __construct(){
        parent::__construct(UserModel::make());        
    }

    public function findUserByEmail(String $email) : ?UserModel{
        return $this->model->where('email',$email)->first();
    }

    public function findDataArrById(int $userId): array {
        $userRec = $this->findById($userId); 
        if(is_null($userRec)) return [];

        $tempuserArr = $userRec->toArray();
        $userArr     = $tempuserArr;
        
        unset($userArr['created_at']);
        unset($userArr['updated_at']);
        unset($userArr['last_login']);
        
        foreach ($userArr['roles'] as $key => $roleArr) {
            unset($userArr['roles'][$key]['permissions']);
            unset($userArr['roles'][$key]['pivot']);
            unset($userArr['roles'][$key]['created_at']);
            unset($userArr['roles'][$key]['updated_at']);
        }
        $userArr['role_arr'] = $userArr['roles'][0];
        unset($userArr['roles']);
        return $userArr;
    }
    
    public function findDtoDataById(int $userId): array {
        $data = $this->findDataArrById($userId);
        return UserMapper::dbRecConvertToEntityArr($data);
    }
    

    /*public function deleteUser(User $userEntity){

        try{
            $userId = $userEntity->getId();
            $isDeleted = parent::deleteById($userId);
            
            if($isDeleted){
                return array('isDeleted' => true, 'id' => $userId);
            }else{
                throw new Exception("")
            }

        }catch (\PDOException $e) {
            return array('isDeleted' => false, 'id' => $userId);
        }catch (\Exception $e) {
            return array('isDeleted' => false, 'id' => $userId);
        }
    }

    public function deleteById($modelId){

        try{

            DB::beginTransaction ();
            
            $thread = $this->findById($modelId);
            if($thread !== null){
                $thread->categories()->detach();

                //delete all posts belong to thread
                $postRepository = new PostRepository();
                foreach ($thread->posts as $post){
                    $isPostDelete = $postRepository->deleteById($post->id);
                    if(!$isPostDelete) throw new Exception("");
                }

                //finally delete thread
                $isThreadDelete = parent::deleteById($modelId);
                if(!$isThreadDelete) throw new Exception("");
            }

            DB::commit();
            return array('isDelete' =>true,'id'=>$modelId);

        }catch (\PDOException $e) {
            DB::rollBack();
            return array('isDelete' =>false,'id'=>$modelId);
        }catch (\Exception $e) {
            DB::rollBack();
            return array('isDeleted' => false, 'id' => $modelId);
        }
    }
    */

}


  