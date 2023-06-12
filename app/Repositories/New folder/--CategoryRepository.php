<?php


namespace App\Repositories;
use  App\Models\Category;
use App\Models\Thread;



class CategoryRepository
{
    public function findByCategoryName($categoryName){
        return Category::where('category_name', $categoryName)->get();
    }

    public function findById($id){
        return Category::find($id);
    }
    public function findMany($idArr){
        return Category::find($idArr);
    }
    public function findAll(){
        return Category::all();
    }

    public function add($categoryName){
        $category = new Category;
        $category->category_name = $categoryName;
        $isInserted = $category->save();
        $id = $category->id;
        return array('isInserted' =>$isInserted,'id'=>$id);
    }

    public function updateById($categoryName,$categoryId){
        $selectedRow = $this->findById($categoryId);

        if($selectedRow){
            $selectedRow->category_name = $categoryName;
            $isUpdated = $selectedRow->save();
            return $isUpdated;
        }else{
            return false;
        }
    }

    public function deleteById($id){
        return Category::destroy($id);
    }

    public function synThreadCategories(Thread $thread, $categoryArr){
        $thread->categories()->sync($categoryArr);
    }

    public function findThreadsByCategory(Category $category){
        $arr = array();
        //var_dump($category->threads);
        //var_dump();

        $threads = $category->threads()->orderBy('created_at','desc')->get();
        foreach($threads as $thread){
            $arr[] = $thread;

        }
        return $arr;
    }




}



/*
 *

class UserRepository
{
    public function create(array $data)
    {
        DB::beginTransaction();

        try {
            $user = new User;

            $user->account_id = $data['account_id'];
            $user->fill($data);
            $user->save();

            $activation = new Activation;
            $activation->user_id = $user->id;
            $activation->save();
        } catch(Exception $e) {
            DB::rollBack();

            throw $e;
        }

        DB::commit();

        return $user;
    }
}


 *
 *
 * */









/////////////////
interface TaskRepositoryInterface
{
    public function getAllTasks();
    public function getTaskById($taskId);
    public function deleteTask($taskId);
    public function createTask(array $taskDetails);
    public function updateTask($taskId, array $newDetails);
}

class TaskRepository implements TaskRepositoryInterface
{
    public function getAllTasks()
    {
        return Task::all();
    }
    public function getTaskById($taskId)
    {
        return Task::findOrFail($taskId);
    }
    public function deleteTask($taskId)
    {
        Task::destroy($taskId);
    }
    public function createTask(array $taskDetails)
    {
        return Task::create($taskDetails);
    }
    public function updateTask($taskId, array $newDetails)
    {
        return Task::whereId($taskId)->update($newDetails);
    }
    
}


////////////////////////////

interface OrderRepositoryInterface 
{
    public function getAllOrders();
    public function getOrderById($orderId);
    public function deleteOrder($orderId);
    public function createOrder(array $orderDetails);
    public function updateOrder($orderId, array $newDetails);
    public function getFulfilledOrders();
}




class OrderRepository implements OrderRepositoryInterface 
{
    public function getAllOrders() 
    {
        return Order::all();
    }

    public function getOrderById($orderId) 
    {
        return Order::findOrFail($orderId);
    }

    public function deleteOrder($orderId) 
    {
        Order::destroy($orderId);
    }

    public function createOrder(array $orderDetails) 
    {
        return Order::create($orderDetails);
    }

    public function updateOrder($orderId, array $newDetails) 
    {
        return Order::whereId($orderId)->update($newDetails);
    }

    public function getFulfilledOrders() 
    {
        return Order::where('is_fulfilled', true);
    }
}








//////////////////////////////////////////


<?php

namespace App\Repository;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface EloquentRepositoryInterface
{
    /**
     * Get all models.
     *
     * @param array $columns
     * @param array $relations
     * @return Collection
     */
    public function all(array $columns = ['*'], array $relations = []): Collection;

    /**
     * Get all trashed models.
     *
     * @return Collection
     */
    public function allTrashed(): Collection;

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
        array $columns = ['*'],
        array $relations = [],
        array $appends = []
    ): ?Model;

    /**
     * Find trashed model by id.
     *
     * @param int $modelId
     * @return Model
     */
    public function findTrashedById(int $modelId): ?Model;

    /**
     * Find only trashed model by id.
     *
     * @param int $modelId
     * @return Model
     */
    public function findOnlyTrashedById(int $modelId): ?Model;

    /**
     * Create a model.
     *
     * @param array $payload
     * @return Model
     */
    public function create(array $payload): ?Model;

    /**
     * Update existing model.
     *
     * @param int $modelId
     * @param array $payload
     * @return bool
     */
    public function update(int $modelId, array $payload): bool;

    /**
     * Delete model by id.
     *
     * @param int $modelId
     * @return bool
     */
    public function deleteById(int $modelId): bool;

    /**
     * Restore model by id.
     *
     * @param int $modelId
     * @return bool
     */
    public function restoreById(int $modelId): bool;

    /**
     * Permanently delete model by id.
     *
     * @param int $modelId
     * @return bool
     */
    public function permanentlyDeleteById(int $modelId): bool;
}


namespace App\Repository;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface EloquentRepositoryInterface
{
    /**
     * Get all models.
     *
     * @param array $columns
     * @param array $relations
     * @return Collection
     */
    public function all(array $columns = ['*'], array $relations = []): Collection;

    /**
     * Get all trashed models.
     *
     * @return Collection
     */
    public function allTrashed(): Collection;

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
        array $columns = ['*'],
        array $relations = [],
        array $appends = []
    ): ?Model;

    /**
     * Find trashed model by id.
     *
     * @param int $modelId
     * @return Model
     */
    public function findTrashedById(int $modelId): ?Model;

    /**
     * Find only trashed model by id.
     *
     * @param int $modelId
     * @return Model
     */
    public function findOnlyTrashedById(int $modelId): ?Model;

    /**
     * Create a model.
     *
     * @param array $payload
     * @return Model
     */
    public function create(array $payload): ?Model;

    /**
     * Update existing model.
     *
     * @param int $modelId
     * @param array $payload
     * @return bool
     */
    public function update(int $modelId, array $payload): bool;

    /**
     * Delete model by id.
     *
     * @param int $modelId
     * @return bool
     */
    public function deleteById(int $modelId): bool;

    /**
     * Restore model by id.
     *
     * @param int $modelId
     * @return bool
     */
    public function restoreById(int $modelId): bool;

    /**
     * Permanently delete model by id.
     *
     * @param int $modelId
     * @return bool
     */
    public function permanentlyDeleteById(int $modelId): bool;
}





<?php

namespace App\Repository\Eloquent;

use App\Repository\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements EloquentRepositoryInterface
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * BaseRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @param array $columns
     * @param array $relations
     * @return Collection
     */
    public function all(array $columns = ['*'], array $relations = []): Collection
    {
        return $this->model->with($relations)->get($columns);
    }

    /**
     * Get all trashed models.
     *
     * @return Collection
     */
    public function allTrashed(): Collection
    {
        return $this->model->onlyTrashed()->get();
    }

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
        array $columns = ['*'],
        array $relations = [],
        array $appends = []
    ): ?Model {
        return $this->model->select($columns)->with($relations)->findOrFail($modelId)->append($appends);
    }

    /**
     * Find trashed model by id.
     *
     * @param int $modelId
     * @return Model
     */
    public function findTrashedById(int $modelId): ?Model
    {
        return $this->model->withTrashed()->findOrFail($modelId);
    }

    /**
     * Find only trashed model by id.
     *
     * @param int $modelId
     * @return Model
     */
    public function findOnlyTrashedById(int $modelId): ?Model
    {
        return $this->model->onlyTrashed()->findOrFail($modelId);
    }

    /**
     * Create a model.
     *
     * @param array $payload
     * @return Model
     */
    public function create(array $payload): ?Model
    {
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
    public function update(int $modelId, array $payload): bool
    {
        $model = $this->findById($modelId);

        return $model->update($payload);
    }

    /**
     * Delete model by id.
     *
     * @param int $modelId
     * @return bool
     */
    public function deleteById(int $modelId): bool
    {
        return $this->findById($modelId)->delete();
    }

    /**
     * Restore model by id.
     *
     * @param int $modelId
     * @return bool
     */
    public function restoreById(int $modelId): bool
    {
        return $this->findOnlyTrashedById($modelId)->restore();
    }

    /**
     * Permanently delete model by id.
     *
     * @param int $modelId
     * @return bool
     */
    public function permanentlyDeleteById(int $modelId): bool
    {
        return $this->findTrashedById($modelId)->forceDelete();
    }
}
