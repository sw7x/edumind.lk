<?php

namespace App\Repositories;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

use App\Repositories\Interfaces\IRepository;



/*
getXCount
XSearchByY
synThreadCategories
updateUserPass
getThreadOwner
*/

class BaseRepository implements IRepository
{
    /**
    * @var Model*/
    
    protected $model;

    /**
    * BaseRepository constructor.
    *
    * @param Model $model*/
    
    public function __construct(Model $model){

        $this->model = $model;
    }

    /**
    * @param array $columns
    * @param array $relations
    * @return Collection
    */
    public function all(array $columns = ['*'], array $relations = []): Collection{
        
        return $this->model->with($relations)->get($columns);
    }

    /**
    * Get all trashed models.
    *
    * @return Collection
    */
    public function allTrashed(): Collection{

        return $this->model->onlyTrashed()->get();
    }

    /**
    * Find model by UUId.
    *
    * @param string $modelUUId
    * @param array $columns
    * @param array $relations
    * @param array $appends
    * @return Model

    public function findByUUId(
        int $modelUUId,
        array $columns      = ['*'],
        array $relations    = [],
        array $appends      = []
    ): ?Model {

        return $this->model->select($columns)->with($relations)->where('uuid',$modelUUId)->append($appends)->get();
    }
    */

    /**
    * Find model by id.
    *
    * @param int $modelId
    * @param array $columns
    * @param array $relations
    * @param array $appends
    * @return Model
    */
    public function findById(
        int $modelId,
        array $columns      = ['*'],
        array $relations    = [],
        array $appends      = []
    ): ?Model {

        $result = $this->model->select($columns)->with($relations)->find($modelId);

        if ($result) {
            $result->append($appends);
        }

        return $result;
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
        
        return $this->model->select($columns)->with($relations)->find($modelIds)->append($appends);
    }

    /**
    * Find trashed model by id.
    *
    * @param int $modelId
    * @return Model
    */
    public function findTrashedById(int $modelId): ?Model{
        
        return $this->model->withTrashed()->find($modelId);
    }

    /**
    * Find only trashed model by id.
    *
    * @param int $modelId
    * @return Model
    */
    public function findOnlyTrashedById(int $modelId): ?Model{
        
        return $this->model->onlyTrashed()->find($modelId);
    }

    /**
    * Create a model.
    *
    * @param array $payload
    * @return Model
    */
    public function create(array $payload): ?Model{
        
        $model = $this->model->create($payload);
        return $model->fresh();
    }

    /**
    * Update existing model.
    *
    * @param int $modelId
    * @param array $payload
    * @return bool
    */
    public function update(int $modelId, array $payload): bool{
        
        $model = $this->findById($modelId);
        return $model->update($payload);
    }

    /**
    * Delete model by id.
    *
    * @param int $modelId
    * @return bool
    */
    public function deleteById(int $modelId): bool{
        
        return $this->findById($modelId)->delete();
    }

    /**
    * Restore model by id.
    *
    * @param int $modelId
    * @return bool
    */
    public function restoreById(int $modelId): bool{
        
        return $this->findOnlyTrashedById($modelId)->restore();
    }

    /**
    * Permanently delete model by id.
    *
    * @param int $modelId
    * @return bool
    */
    public function permanentlyDeleteById(int $modelId): bool{

        return $this->findTrashedById($modelId)->forceDelete();
    }
}



