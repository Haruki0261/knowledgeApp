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
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'users';

    protected $fillable = [
        'slack_id',
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
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
            ['slack_id' => $slackUser->id, 'email' => $slackUser->email, 'name' => $slackUser->name, 'password' => Hash::make(Str::random())
            ]);

        return $user;
    }
}
