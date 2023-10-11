<?php

namespace App\Repositories;

use App\Models\Commission as CommissionModel;

use App\Repositories\BaseRepository;
use App\Repositories\UserRepository;
use App\Repositories\Interfaces\IGetDataRepository;
use App\Mappers\CommissionMapper;


class CommissionRepository extends BaseRepository implements IGetDataRepository
{
    
	public function __construct(){
        parent::__construct(CommissionModel::make());        
    }

    public function findDataArrById(int $commissionId): array{

        $commissionRec    = $this->findById($commissionId);   
        if(is_null($commissionRec)) return [];

        $commissionRecArr = $commissionRec->toArray();

        unset($commissionRecArr['created_at']);
        unset($commissionRecArr['updated_at']);
        unset($commissionRecArr['deleted_at']);
        

        $userRec    =   $this->model                        
                            ->join('enrollments', 'commissions.id', '=', 'enrollments.commission_id')                            
                            ->join('course_selections', 'enrollments.course_selection_id', '=', 'course_selections.id')
                            ->join('coupons', 'course_selections.used_coupon_code', '=', 'coupons.code')
                            ->join('users', 'coupons.beneficiary_id', '=', 'users.id')
                            ->where('commissions.id',$commissionId)
                            ->get(['commissions.*', 'users.id as user_id']);
    
        //dd($userRec);

        $userId = $userRec->isNotEmpty() ? $userRec->first()->user_id : null;     
        
        $userDataArr = ($userId) ? (new UserRepository())->findDataArrById($userId) : [];
        $commissionRecArr['beneficiary_arr'] =  $userDataArr;
        $commissionRecArr['beneficiary_id'] =  $userId;

        $courseSelRecs  =   $this->model                        
                                ->join('enrollments', 'commissions.id', '=', 'enrollments.commission_id')                            
                                ->join('course_selections', 'enrollments.course_selection_id', '=', 'course_selections.id')
                                ->where('commissions.id',$commissionId)
                                ->orderBy('commissions.paid_date')
                                ->get(['course_selections.*']);

        $courseSelRecArr = $courseSelRecs->isNotEmpty() ? $courseSelRecs->toArray() : [];     
        
        $feeDataArr = array(); 
        foreach ($courseSelRecArr as $courseSelRec) {
            
            $commissionAmount = $courseSelRec['beneficiary_earn_amount'];
            if(!$commissionAmount) continue;
            
            $feeDataArr[]    =   array(
                'id'        => $courseSelRec['id'],
                //'uuid'      => $courseSelRec['uuid'],
                'amount'    => $courseSelRec['beneficiary_earn_amount'],
            );
        }       
        
        $commissionRecArr['fees'] =  $feeDataArr;    
        return $commissionRecArr;
    }


    public function findDtoDataById(int $commissionId): array {
        $data = $this->findDataArrById($commissionId);
        return CommissionMapper::dbRecConvertToEntityArr($data);
    }

    

}
