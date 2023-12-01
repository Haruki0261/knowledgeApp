<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostImages extends Model
{
    use HasFactory;

    protected $table = 'post_images';
    protected $fillable = ['post_id', 'user_id', 'fileName'];

    /**
     * 新規投稿処理
     *
     * @param array $postImage
     *
     * @return Void
     */
    public function createImage(array $postImage): Void
    {
        PostImages::insert($postImage);
    }

    /**
     * 指定した投稿内の画像を取得する。
     *
     * @param int $postId
     *
     * @return Collection
     */
    public function getPostImage(int $postId): Collection
    {
        return  PostImages::where('post_id', $postId)->get();
    }

    /**
     * もし画像が既に投稿されていなかったら、DBにINSERTする。入っていたら、updateする。
     *
     * @param int $userId
     * @param int $postId
     * @param string  $imagePath
     * @return void
     */
    public function updateImage(int $userId, int $postId, string $imagePath)
    {
        $postImages = PostImages::where('post_id', $postId)->get();

        if($postImages->isEmpty())
        {
            PostImages::insert(['user_id' => $userId, 'post_id' => $postId, 'img_path' => $imagePath]);
        }
        PostImages::where('post_id', $postId)->update(['img_path' => $imagePath]);
    }
}

