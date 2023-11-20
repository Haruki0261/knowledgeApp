<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

use function PHPUnit\Framework\isNull;

class LoginController extends Controller
{
    /**
     * コンストラクタ(インスタンス生成)
     *
     * @var Users
     */
    private $users;
    public function __construct(Users $users)
    {
        $this->users = $users;
    }

    /**
     * 認証エンドポイントにリダイレクト
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function redirectToProvider(Request $request): RedirectResponse
    {
        $provider = $request->provider;

        return Socialite::driver($provider)->redirect();

    }

    /**
    * Slack,Google認証処理
     *
     * @param Request $request
     *
     * @return RedirectResponse|view
     */
    public function handleProviderCallback(Request $request): RedirectResponse|view
    {
        try{
            $provider = $request->provider;
            $snsUser = Socialite::driver($provider)->user();
            $user = $this->users->createSlackUser($snsUser);
            auth()->login($user);

            return redirect()->route('Knowledge.index');
        }catch(Exception $e){
            logger($e);

            return view('auth.register');
        }
    }
}


