<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
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

    /**
     * 全ての投稿を取得する
     *
     * @return Collection
     */
    public function getAllPosts(): Collection
    {
        $posts = Posts::with('users')->get();

        return $posts;
    }

    /**
     * ユーザーが指定した投稿を取得
     *
     * @param integer $postId
     *
     * @return Collection
     */
    public function getPost(int $postId): Collection
    {
        return Posts::where('id', $postId)
                ->with(['users'])
                ->get();
    }

    /**
     * Pathパラメーターと一致したレコードを更新する。
     *
     * @param int $postId
     * @param string $title
     * @param string $content
     *
     * @return void
     */
    public function updatePost(int $postId, string $title, string $content): void
    {
        Posts::find($postId)->update(['title' => $title, 'content' => $content]);
    }

    /**
     * Pathパラメーターに一致したレコードの、ユーザーIDを取得する
     *
     * @param int $postId
     *
     * @return int
     */
    public function getPostId(int $postId): int
    {
        return Posts::find($postId)->user_id;
    }
}
