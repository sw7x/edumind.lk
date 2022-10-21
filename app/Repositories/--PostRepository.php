<?php


namespace App\Repositories;
use App\Models\Post;
use  App\Models\Thread;
use Illuminate\Support\Facades\DB;

class PostRepository
{
    public function findPostBelongThread($postId){
        return Post::find($postId)->thread()->get();
    }

    public function findById($id){
        return Post::find($id);
    }

    public function add($text,$userId,$threadId){
        try
        {
            $post = new Post;
            $post->post_text = $text;
            $post->thread_id = $threadId;
            $post->user_id   = $userId;
            $post->save ();
            $id = $post->id;

            return array('isInserted' =>true,'id'=>$id);

        }catch (\PDOException $e) {
            return array('isInserted' =>false,'id'=>null);
        }

    }

    public function updateById($text,$userId,$threadId,$isUseful,$id){
        $selectedPost = $this->findById($id);
        //var_dump(bool($isUseful));
        try
        {
            $selectedPost->post_text    = $text;
            $selectedPost->thread_id    = $threadId;
            $selectedPost->user_id      = $userId;
            $selectedPost->is_useful    = filter_var($isUseful, FILTER_VALIDATE_BOOLEAN);
            $selectedPost->save();

            return array('isUpdated' =>true,'id'=>$id);

        }catch (\PDOException $e) {
            return array('isUpdated' =>false,'id'=>null);
        }
    }

    public function deleteById($id){
        return Post::destroy($id);
    }
}
