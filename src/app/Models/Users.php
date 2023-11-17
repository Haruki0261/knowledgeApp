<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use PhpParser\Node\Expr\BinaryOp\BooleanOr;

class Users extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Userテーブルにアクセス
     */
    protected $table = 'users';

    /**
     * Userテーブルの特定のカラムにアクセス可能
     */
    protected $fillable = [
        'slack_id',
        'name',
        'email',
        'password',
    ];

    /**
     *　非表示にするカラム
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * datetimeに型指定
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * UserテーブルにSlackのIdが既に存在するかどうかの判別
     *
     * @param int $slackId
     *
     * @return bool
     */
    public function existByUserId($slackId): bool
    {
        return Users::where('id', $slackId)->exists();
    }

    /**
     * データベースにデータがなければ、レコードを作成し、Usersテーブルに挿入
     *
     * @param SocialiteUser $slackUser
     *
     * @return Users
     */
    public function createSlackUser($slackUser)
    {
        $user = Users::firstOrCreate(
            ['slack_id' => $slackUser->id],
            ['slack_id' => $slackUser->id,
            'email' => $slackUser->email,
            'name' => $slackUser->name,
            'password' => Hash::make(Str::random())
            ]);

        return $user;
    }
}
