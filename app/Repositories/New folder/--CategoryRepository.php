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
