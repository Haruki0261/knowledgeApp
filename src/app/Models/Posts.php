<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    use HasFactory;

    protected $table = 'posts';
    protected $fillable = ['user_id', 'title', 'content'];

    /**
     * 投稿をpostテーブルに保存($post->idをreturnしたのは、画像保存処理に使うため)
     *
     * @param int $userId
     * @param string $title
     * @param string $content
     *
     * @return int
     */
    public function createPost($userId, $title, $content)
    {
        $posts = new Posts();
        $posts->user_id = $userId;
        $posts->title = $title;
        $posts->content = $content;

        $posts->save();

        return $posts->id;
    }



}
