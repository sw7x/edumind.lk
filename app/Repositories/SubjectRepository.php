<?php

namespace App\Repositories;

use App\Models\Subject as SubjectModel;
use App\Models\User as UserModel;

use App\Repositories\BaseRepository;
use App\Repositories\UserRepository;

use App\Repositories\Interfaces\IGetDataRepository;
use App\Mappers\SubjectMapper;
use Illuminate\Database\Eloquent\Collection;



class SubjectRepository extends BaseRepository implements IGetDataRepository {
        
    public function __construct(){
        parent::__construct(SubjectModel::make());
    }   
    
    
    /**
    * @param array $columns
    * @param array $relations
    * @return Collection
    */
    public function all(array $columns = ['*'], array $relations = []): Collection{
        
        return  $this->model->withoutGlobalScope('published')
                    ->with($relations)
                    ->withCount($relations)
                    ->orderBy('id')
                    ->get($columns);
    }
    
    /**
    * @param array $columns
    * @param array $relations
    * @return Collection
    */
    public function allWithGlobalScope(array $columns = ['*'], array $relations = []): Collection{
        return parent::all($columns, $relations);        
    }
    

    


    /**
    * Find model by id.
    *
    * @param int $modelId
    * @param array $columns
    * @param array $relations
    * @param array $appends
    * @return SubjectModel
    */
    public function findById(
        int $modelId,
        array $columns      = ['*'],
        array $relations    = [],
        array $appends      = []
    ) : ?SubjectModel{
        
        $result =   $this->model->withoutGlobalScope('published')
                        ->select($columns)->with($relations)->find($modelId);

        if ($result) {
            $result->append($appends);
        }
        return $result;
    }
    
    /**
    * Find trashed model by id.
    *
    * @param int $modelId
    * @param array $columns
    * @param array $relations
    * @param array $appends
    * @return SubjectModel
    */
    public function findByIdIncludingTrashed(
        int $modelId,
        array $columns      = ['*'],
        array $relations    = [],
        array $appends      = []
    ) : ?SubjectModel{
        
        $result =   $this->model->withTrashed()->withoutGlobalScope('published')
                        ->select($columns)
                        ->with($relations)
                        ->withCount($relations)
                        ->find($modelId);

        if ($result) {
            $result->append($appends);
        }
        return $result;
    }

    /**
    * Find model by id.
    *
    * @param int $modelId
    * @param array $columns
    * @param array $relations
    * @param array $appends
    * @return SubjectModel
    */
    public function findByIdWithGlobalScope(
        int $modelId,
        array $columns      = ['*'],
        array $relations    = [],
        array $appends      = []
    ) : ?SubjectModel{        
        return parent::findById($modelId, $columns, $relations, $appends);
    }


    /**
    * Find models by ids.
    *
    * @param array $modelIds
    * @param array $columns
    * @param array $relations
    * @param array $appends
    * @return Collection
    */
    public function findManyByIds(
        array $modelIds     = [],
        array $columns      = ['*'],
        array $relations    = [],
        array $appends      = []
    ): ?Collection {
        
        return  $this->model->withoutGlobalScope('published')
                    ->select($columns)->with($relations)->find($modelIds)->append($appends);
    }
    

    /**
    * Find models by ids.
    *
    * @param array $modelIds
    * @param array $columns
    * @param array $relations
    * @param array $appends
    * @return Collection
    */
    public function findManyByIdsWithGlobalScope(
        array $modelIds     = [],
        array $columns      = ['*'],
        array $relations    = [],
        array $appends      = []
    ): ?Collection {
        return parent::findManyByIds($modelIds, $columns, $relations, $appends);
    }


    



    public function findByName(String $name) : ?Collection{
        return $this->model->withTrashed()->withoutGlobalScope('published')->where('name',$name)->get();
    }    

    public function findByUrl(String $url) : ?SubjectModel{
        return $this->model->withTrashed()->withoutGlobalScope('published')->where('slug',$slug)->first();
    }    

    public function findDuplicateCountByName(string $subjectName, int $id) : int {
        return $this->model->withTrashed()->withoutGlobalScope('published')->where('id', '!=', $id)->where('name', '=', $subjectName)->count();
    }


    public function findAvailableByName(String $url) : ?SubjectModel{
        return $this->model->where('name',$name)->get();
    }

    public function findAvailableByUrl(String $url) : ?SubjectModel{
        return $this->model->where('slug',$url)->first();
    }

    public function findAvailableDuplicateCountByName(string $subjectName, int $id) : int {
        return $this->model->where('id', '!=', $id)->where('name', '=', $subjectName)->count();
    }




    public function findDataArrById(int $subjectId) : array{
        //dd($subjectId);
        //$subjectRec    = $this->findById($subjectId); 
        $subjectRec    = $this->findByIdIncludingTrashed($subjectId); 

        if(is_null($subjectRec)) return [];

        $subjectArr = $subjectRec->toArray();
        $authorId   = $subjectArr['author_id'];
        $subjectArr['creator_id'] = $authorId;
		
        //unset($subjectArr['author_id']);
        unset($subjectArr['created_at']);
        unset($subjectArr['updated_at']);
        //unset($subjectArr['deleted_at']);
    
        $creatorDataArr = ($authorId) ? (new UserRepository())->findDataArrById($authorId) : [];        
        $subjectArr['creator_arr'] =  $creatorDataArr;
        return $subjectArr;
    }  

    public function findDtoDataById(int $subjectId) : array {
        $data = $this->findDataArrById($subjectId);
        return SubjectMapper::dbRecConvertToEntityArr($data);
    }


    /**
    * Permanently delete model by id.
    *
    * @param int $modelId
    * @return bool
    */
    public function permanentlyDeleteById(int $modelId): bool{
        return $this->findByIdIncludingTrashed($modelId)->forceDelete();
    }


    /**
    * Get all trashed models.
    *
    * @return Collection
    */
    public function allTrashed(): Collection{

        return $this->model->withoutGlobalScope('published')->onlyTrashed()->get();
    }

    /**
    * Find trashed model by id.
    *
    * @param int $modelId
    * @return SubjectModel
    */
    public function findTrashedById(int $modelId): ?SubjectModel{
        
        return $this->model->withoutGlobalScope('published')->withTrashed()->find($modelId);
    }

    /**
    * Find only trashed model by id.
    *
    * @param int $modelId
    * @return SubjectModel
    */
    public function findOnlyTrashedById(int $modelId): ?SubjectModel{
        
        return $this->model->withoutGlobalScope('published')->onlyTrashed()->find($modelId);
    }


    public function getAllSubjectsByUserIncludingTrashed(UserModel $teacher) : ?Collection {
        return $teacher->subjects()->withTrashed()->withoutGlobalScope('published')->get();
    }

}