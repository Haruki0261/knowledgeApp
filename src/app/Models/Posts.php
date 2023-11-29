<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Posts extends Model
{
    use HasFactory;

    protected $table = 'posts';
    protected $fillable = ['user_id', 'title', 'content'];

    /**
     * リレーション（Usersテーブルのidと、Postsテーブルのuser_idを紐付ける）
     *
     * @return hasOne
     */
    public function Users(): hasOne
    {
        return $this->hasOne(Users::class, 'id', 'user_id');
    }

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

    public function getAllPosts()
    {
        $posts = Posts::with('users')->get();

        return $posts;
    }
}
