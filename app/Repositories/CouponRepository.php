<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;


use App\Models\Coupon as CouponModel;

use App\Repositories\Interfaces\ICouponRepository;
use App\Mappers\CouponMapper;


class CouponRepository implements ICouponRepository{
    

    /**
    * @param array $columns
    * @param array $relations
    * @return Collection
    */
    public function all(array $columns = ['*'], array $relations = []): Collection {
        return CouponModel::withoutGlobalScope('enabled')->with($relations)->get($columns);
    }


    /**
    * @param array $columns
    * @param array $relations
    * @return Collection
    */
    public function allWithGlobalScope(array $columns = ['*'], array $relations = []): Collection {
        return CouponModel::with($relations)->get($columns);
    }





    /**
    * Get all trashed models.
    *
    * @return Collection
    */
    public function allTrashed() : Collection {
        return CouponModel::onlyTrashed()->get();
    }
    
    /**
    * Find model by UUId.
    *
    * @param string $modelUUId
    * @param array $columns
    * @param array $relations
    * @param array $appends
    * @return CouponModel
    
    public function findByUUId(
        int $modelUUId,
        array $columns      = ['*'],
        array $relations    = [],
        array $appends      = []
    ): ?CouponModel {
        return CouponModel::select($columns)->with($relations)->where('uuid',$modelUUId)->append($appends)->get();
    }
    */

    /**
    * Find model by id.
    *
    * @param int $modelCode
    * @param array $columns
    * @param array $relations
    * @param array $appends
    * @return CouponModel
    */
    public function findByCode(
        string $modelCode,
        array $columns      = ['*'],
        array $relations    = [],
        array $appends      = []
    ): ?CouponModel {        
        $result = CouponModel::withoutGlobalScope('enabled')->select($columns)->with($relations)->find($modelCode);
        if ($result)
            $result->append($appends);
        //return CouponModel::select($columns)->with($relations)->find($modelCode)->append($appends);
        return $result;
    }


    /**
    * Find model by id.
    *
    * @param int $modelCode
    * @param array $columns
    * @param array $relations
    * @param array $appends
    * @return CouponModel
    */
    public function findByCodeWithGlobalScope(
        string $modelCode,
        array $columns      = ['*'],
        array $relations    = [],
        array $appends      = []
    ): ?CouponModel {        
        $result = CouponModel::select($columns)->with($relations)->find($modelCode);
        if ($result)
            $result->append($appends);
        //return CouponModel::select($columns)->with($relations)->find($modelCode)->append($appends);
        return $result;
    }


    /**
    * Find models by ids.
    *
    * @param array $modelCodes
    * @param array $columns
    * @param array $relations
    * @param array $appends
    * @return Collection
    */
    public function findManyByCodes(
        array $modelCodes     = [],
        array $columns      = ['*'],
        array $relations    = [],
        array $appends      = []
    ): ?Collection {        
        return CouponModel::withoutGlobalScope('enabled')->select($columns)->with($relations)->find($modelCodes)->append($appends);
    }


    /**
    * Find models by ids.
    *
    * @param array $modelCodes
    * @param array $columns
    * @param array $relations
    * @param array $appends
    * @return Collection
    */
    public function findManyByCodesWithGlobalScope(
        array $modelCodes     = [],
        array $columns      = ['*'],
        array $relations    = [],
        array $appends      = []
    ): ?Collection {        
        return CouponModel::select($columns)->with($relations)->find($modelCodes)->append($appends);
    }

    /**
    * Find trashed model by id.
    *
    * @param string $modelCode
    * @return CouponModel
    */
    public function findTrashedByCode(string $modelCode): ?CouponModel{
        return CouponModel::withTrashed()->find($modelCode);
    }

    /**
    * Find only trashed model by id.
    *
    * @param string $modelCode
    * @return CouponModel
    */
    public function findOnlyTrashedByCode(string $modelCode): ?CouponModel {
        return CouponModel::onlyTrashed()->find($modelCode);
    }

    /**
    * Create a model.
    *
    * @param array $payload
    * @return CouponModel
    */
    public function create(array $payload, bool $updateTimestamps = true): ?CouponModel {        
        $model = CouponModel::create($payload);
        return $model->fresh();
    }

    /**
    * Update existing model.
    *
    * @param int $modelCode
    * @param array $payload
    * @return bool
    */
    public function update(string $modelCode, array $payload, bool $updateTimestamps = true): bool {        
        $model              = $this->findByCode($modelCode);
        $model->timestamps  = $updateTimestamps;
        $isUpdated          = $model->update($payload);
        $model->timestamps  = true;
        return $isUpdated;
     }

    /**
    * Delete model by id.
    *
    * @param string $modelCode
    * @return bool
    */
    public function deleteByCode(string $modelCode): bool {        
        return $this->find($modelCode)->delete();
    }

    /**
    * Restore model by id.
    *
    * @param string $modelCode
    * @return bool  
    */
    public function restoreByCode(string $modelCode): bool {        
        return $this->findOnlyTrashedByCode($modelCode)->restore();
    }

    /**
    * Permanently delete model by id.
    *
    * @param string $modelCode
    * @return bool
    */ 
    public function permanentlyDeleteByCode(string $modelCode): bool {        
        return $this->findTrashedByCode($modelCode)->forceDelete();
    }
        
    
    public function findDataArrByCode(string $couponCode) : array {
        $couponRec    = $this->findByCode($couponCode); 
        if(is_null($couponRec)) return [];

        $couponArr      = $couponRec->toArray();
        
        $courseId       = $couponArr['cc_course_id'];
		$couponArr['assigned_course_id'] = $courseId;
        $beneficiaryId  = $couponArr['beneficiary_id'];
                
        //unset($couponArr['cc_course_id']);
        //unset($couponArr['beneficiary_id']);
        unset($couponArr['created_at']);
        unset($couponArr['updated_at']);
        unset($couponArr['deleted_at']);

        
        $beneficiaryDataArr = ($beneficiaryId) ? (new UserRepository())->findDataArrById($beneficiaryId) : [];
        $couponArr['beneficiary_arr'] =  $beneficiaryDataArr;

        $courseDataArr = ($courseId) ? (new CourseRepository())->findDataArrById($courseId) : [];
        $couponArr['assigned_course_arr'] =  $courseDataArr;
        return $couponArr;
    }
    
    public function findDtoDataByCode(string $couponCode): array {
        $data = $this->findDataArrByCode($couponCode);
        return CouponMapper::dbRecConvertToEntityArr($data);
    }
    
}


