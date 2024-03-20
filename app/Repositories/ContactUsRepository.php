<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Models\ContactUs as ContactUsModel;
use App\Models\User as UserModel;

use App\Repositories\Interfaces\IGetDataRepository;
use App\Mappers\ContactUsMapper;
use Illuminate\Database\Eloquent\Collection;


class ContactUsRepository extends BaseRepository implements IGetDataRepository{
    
    public function __construct(){
        parent::__construct(ContactUsModel::make());        
    }


    public function getAllStudentContactMessages() : ?Collection {

        $studentComments    =   $this->model->select('contact_us.*', 'users.status as userStat')
                                    ->whereHas('user', function ($query){
                                        $query->withoutGlobalScope('active')
                                            ->withTrashed()                                        
                                            ->whereHas('roles', function ($query){
                                                $query->where('name', 'student');
                                            });
                                    })
                                    ->join('users', 'contact_us.user_id', '=', 'users.id')
                                    ->orderBy('contact_us.created_at', 'desc')
                                    //->toSql();
                                    ->get();
        return $studentComments;
    }
    

    public function getAllTeacherContactMessages() : ?Collection {

        $teacherComments    =   $this->model->select('contact_us.*', 'users.status as userStat','users.profile_pic as profilePic')
                                    ->whereHas('user', function ($query){
                                        $query->withoutGlobalScope('active')
                                        ->whereHas('roles', function ($query){
                                            $query->where('name', 'teacher');
                                        });
                                    })
                                    ->join('users', 'contact_us.user_id', '=', 'users.id')
                                    ->orderBy('contact_us.created_at', 'desc')
                                    //->toSql();
                                    ->get();
        return $teacherComments;
    }    

    
    // comments belongs to marketers and editors
    public function getAllOtherUserContactMessages() : ?Collection {
        $otherUserComments  =   $this->model->select('contact_us.*', 'users.status as userStat', 'roles.name as roleName')
                                    ->whereHas('user', function ($query){
                                        $query->withoutGlobalScope('active')
                                        ->whereHas('roles', function ($query){
                                            $query->where('name', 'marketer')
                                                ->orWhere('name', 'editor');
                                        });
                                    })
                                    ->join('users', 'contact_us.user_id', '=', 'users.id')
                                    ->join('role_users', 'users.id', '=', 'role_users.user_id')
                                    ->join('roles', 'role_users.role_id', '=', 'roles.id')
                                    ->orderBy('contact_us.created_at', 'desc')
                                    //->toSql();
                                    ->get();                            
        return $otherUserComments;
    }

    
    public function getAllGuestContactMessages() : ?Collection {

        $guestMessages  =   $this->model->where('user_id', null)
                                ->orderBy('contact_us.created_at', 'desc')
                                ->get();                           
        return $guestMessages;
    }



    
    public function findDataArrById(int $contactUsMsgId): array {

        $contactUsMsgRec    = $this->findById($contactUsMsgId);   
        if(is_null($contactUsMsgRec)) return [];

        $contactUsMsgArr = $contactUsMsgRec->toArray();
        $userId  = $contactUsMsgArr['user_id'];
                
        //unset($contactUsMsgArr['user_id']);
        unset($contactUsMsgArr['created_at']);
        unset($contactUsMsgArr['updated_at']);
        unset($contactUsMsgArr['deleted_at']);
        
        $userDataArr = ($userId) ? (new UserRepository())->findDataArrById($userId) : [];
        $contactUsMsgArr['user_arr'] =  $userDataArr;
        return $contactUsMsgArr;
    }

    public function findDtoDataById(int $contactUsMsgId): array {
        $data = $this->findDataArrById($contactUsMsgId);
        return ContactUsMapper::dbRecConvertToEntityArr($data);
    }
      
    public function getAllContactMessagesUser(UserModel $userRec) : ?Collection{
        return $userRec->getContactMessages;
    }

}
