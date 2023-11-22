<?php

namespace App\Http\Controllers;

use App\Models\Users;
use App\Models\SlackUser;
use App\Models\GoogleUser;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Socialite\Facades\Socialite;

use function PHPUnit\Framework\isNull;

class LoginController extends Controller
{
    /**
     * コンストラクタ(インスタンス生成)
     *
     * @var Users
     * @var SlackUser
     * @var GoogleUser
     */
    private $users;
    private $slackUser;
    private $googleUser;

    public function __construct(
        Users $users,
        SlackUser $slackUser,
        GoogleUser $googleUser
    )
    {
        $this->users = $users;
        $this->slackUser = $slackUser;
        $this->googleUser = $googleUser;
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
        $provider = $request->provider;
        $snsUser = Socialite::driver($provider)->user();

        DB::beginTransaction();

        try{
            $user = $this->users->createSnsUser($snsUser);
            auth()->login($user);
            $userId = Auth::id();

            if($provider === "slack"){
                $this->slackUser->createSlackUser($snsUser, $userId);
            }else{
                $this->googleUser->createGoogleUser($snsUser, $userId);
            }

            DB::commit();

            return redirect()->route('Knowledge.index');
        }catch(Exception $e){
            logger($e);

            DB::rollBack();
            return view('auth.register');
        }
    }

    /**
     * ログアウト
     *
     * @return View
     */
    public function logout(): View
    {
        Auth::logout();

        return view('auth.register');
    }
}


