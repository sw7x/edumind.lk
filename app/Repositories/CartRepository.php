<?php


namespace App\Repositories;


class ContactUsRepository
{
    



}




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