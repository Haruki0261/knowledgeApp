<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\belongsTo;

class GoogleUser extends Model
{
    use HasFactory;

    /**
     * google_userテーブルにアクセス
     */
    protected $table = 'google_user';

    /**
     * google_userテーブルの特定のカラムにアクセス可能
     */
    protected $fillable = [
        'google_id',
        'user_id'
    ];

    /**
     * リレーション（Userテーブルのidと、google_userテーブルのuser_idを紐付けるため
     *
     * @return belongsTo
     */
    public function User(): belongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * google_userテーブルにidが入っていない場合、googleIdと、userIdを入れる。
     *
     * @param SocialiteUser $snsUser
     * @param int $userId
     *
     * @return Void
     */
    public function createGoogleUser($snsUser, $userId): Void
    {
        GoogleUser::firstOrCreate(
            ['google_id' => $snsUser->id],
            ['google_id' => $snsUser->id, 'user_id' => $userId
        ]);
    }
}
