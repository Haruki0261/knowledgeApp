<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;

class Users extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Userテーブルにアクセス
     */
    protected $table = 'users';

    /**
     *　Usersテーブルの特定のカラムにアクセス可能
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * 非表示にするカラム
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * 型指定
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * リレーション（Userテーブルのidとslack_userテーブルのuser_idを紐づける）
     *
     * @return hasOne
     */
    public function slackUser(): hasOne
    {
        return $this->hasOne(slack_user::class, 'user_id');
    }

    /**
     * リレーション（Userテーブルのidとgoogle_userテーブルのuser_idを紐づける）
     *
     * @return void
     */
    public function googleUser(): hasOne
    {
        return $this->hasOne(google_user::class, 'user_id');
    }

    /**
     * リレーション（Postsテーブルのuser_idと、Userテーブルのidを紐づける）
     *
     * @return belongsToMany
     */
    public function posts(): belongsToMany
    {
        return $this->belongsToMany(posts::class);
    }

    /**
     * データベースにデータがなければ、レコードを作成し、Usersテーブルに挿入
     *
     * @param SocialiteUser $snsUser
     *
     * @return Users
     */
    public function createSnsUser($snsUser): Users
    {
        $user = Users::firstOrCreate(
            ['email' => $snsUser->email],
            [
                'email' => $snsUser->email,
                'name' => $snsUser->name,
                'password' => Hash::make(Str::random())
            ]
        );

        return $user;
    }
}
