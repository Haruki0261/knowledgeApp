<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Laravel\Socialite\Facades\Socialite;

use function PHPUnit\Framework\isNull;

class LoginController extends Controller
{
    /**
     * コンストラクタ（インスタンス生成）
     */
    private $users;
    public function __construct(Users $users)
    {
        $this->users = $users;
    }

    /**
     * 認証エンドポイントにリダイレクト
     *
     * @return RedirectResponse
     */
    public function redirectToProvider(): RedirectResponse
    {
        return Socialite::driver('slack')->redirect();

    }

    /**
     * Slack認証処理
     *
     * @return RedirectResponse|view
     */
    public function handleProviderCallback(): RedirectResponse|view
    {
        try{
            $slackUser = Socialite::driver('slack')->user();
            $user = $this->users->createSlackUser($slackUser);

            auth()->login($user);
            return redirect()->route('Knowledge.index');
        }catch(Exception $e){
            logger($e);

            return view('auth.register');
        }
    }
}


