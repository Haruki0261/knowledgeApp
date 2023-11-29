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
     * @param  int $userId
     * @param  string $imagePath
     * @param int $postId
     *
     * @return Void
     */
    public function createImage($userId, $imagePath, $postId): Void
    {
        $postImage = new PostImages;
        $postImage->post_id = $postId;
        $postImage->user_id = $userId;
        $postImage->img_path = $imagePath;

        $postImage->save();
    }

    /**
     * 指定した投稿内の画像を取得する。
     *
     * @param int $postId
     *
     * @return Collection
     */
    public function getPostImage($postId): Collection
    {
        $postImage = PostImages::where('post_id', $postId)->get();

        return $postImage;
    }
}

