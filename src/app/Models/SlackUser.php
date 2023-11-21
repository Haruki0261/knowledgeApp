<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\belongsTo;


class SlackUser extends Model
{
    use HasFactory;

    /**
     * slack_userテーブルにアクセス
     */
    protected $table = 'slack_user';

    /**
     * slack_userテーブルの特定のカラムにアクセス可能
     *
     * @var array
     */
    protected $fillable = [
        'slack_id',
        'user_id'
    ];

    /**
     * リレーション（Userテーブルのidと、slack_userテーブルのuser_idを紐付けるため
     *
     * @return belongsTo
     */
    public function User(): belongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * slack_userテーブルにidが入っていない場合、slackIdと、userIdを入れる。
     *
     * @param SocialiteUser $snsUser
     * @param int $userId
     *
     * @return void
     */
    public function createSlackUser($snsUser, $userId): Void
    {
        SlackUser::firstOrCreate(
        ['slack_id' => $snsUser->id],
        ['slack_id' => $snsUser->id, 'user_id' => $userId
        ]);
    }
}
