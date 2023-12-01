<?php

namespace App\Http\Controllers;

use App\Models\Posts;
use App\Models\PostImages;
use App\Http\Requests\PostRequest;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Type\Integer;

class KnowledgeController extends Controller
{
    /**
     * コンストラクタ(インスタンスの生成)
     *
     * @var Posts
     * @var PostImages
     */
    private $posts;
    private $postImages;
    public function __construct(
        Posts $posts,
        PostImages $postImages
    )
    {
        $this->posts = $posts;
        $this->postImages = $postImages;
    }

    /**
     * 投稿一覧画面（top画面に遷移）
     *
     * @return View
     */
    public function index(): View
    {
        $posts = $this->posts->getAllPosts();

        return view('top.index', compact('posts'));
    }

    /**
     * 新規投稿画面に遷移
     *
     * @return View
     */
    public function create(): View
    {
        return view('Knowledge.post');
    }

    /**
     * 新規投稿処理
     *
     * @param PostRequest $request
     *
     * @return RedirectResponse
     */
    public function createPost(PostRequest $request): RedirectResponse
    {
        $userId = Auth::id();
        $title = $request->input('title');
        $content = $request->input('content');
        $images = $request->file('images');

        DB::beginTransaction();

        try{
            $postId = $this->posts->createPost($userId, $title, $content);

            $postImage = [];

            if(!is_null($images)){
                foreach ($images as $image) {
                    $imagePath = $image->store('public/avatar');
                    $postImage = [
                        'post_id' => $postId,
                        'user_id' => $userId,
                        'img_path' => $imagePath
                    ];
                }
            }
            $this->postImages->createImage($postImage);

            DB::commit();

            return redirect()->route('Knowledge.index')->with('flash_message', '投稿が完了しました');
        }catch(Exception $e){
            logger($e);

            DB::rollback();

            return redirect()->route('Knowledge.index')->with('flash_message', '投稿に失敗しました');
        }
    }

    /**
     * 指定した投稿を取得
     *
     * @param int $postId
     *
     * @return View
     */
    public function KnowledgeDetail($postId): View
    {
        $posts = $this->posts->getPost($postId);
        $postImages = $this->postImages->getPostImage($postId);

        return view('post.detail', compact('posts', 'postImages'));
    }

    /**
     * 編集画面に遷移
     *
     * @param integer $postId
     *
     * @return View
     */
    public function showEdit(int $postId): View
    {
        $posts = $this->posts->getPost($postId);
        $postImages = $this->postImages->getPostImage($postId);

        return view('post.edit', compact('posts', 'postImages'));
    }

    /**
     * 認可
     *
     * @param int $postId
     * 
     * @return bool
     */
    public function isAuthenticatedUserPost(int $postId): bool
    {
        return $this->posts->getPostId($postId) === Auth::id();
    }


    /**
     * 投稿編集処理
     *
     * @param PostRequest $request
     * @param int $postId
     *
     * @return RedirectResponse
     */
    public function updatePost(PostRequest $request, int $postId): RedirectResponse
    {
        $userId = Auth::id();
        $title = $request->input('title');
        $content = $request->input('content');
        $images = $request->file('images');

        $flashMessage = "投稿編集に成功しました";

        DB::beginTransaction();

        try{
            if($this->isAuthenticatedUserPost($postId)){
                $this->posts->updatePost($postId, $title, $content);
                $postedImages = $this->postImages->getPostImage($postId);

                foreach ($postedImages as $postedImage) {
                    Storage::delete($postedImage->img_path);
                }

                if (!is_null($images)) {
                    foreach ($images as $image) {
                        $imagePath = $image->store('public/avatar');
                    }
                $this->postImages->updateImage($userId, $postId, $imagePath);
                }
            }

            DB::commit();

            return redirect()->route('Knowledge.detail', ['id' => $postId])->with('flashMessage', $flashMessage);
        }catch(Exception $e){
            Logger($e);

            DB:: rollBack();

            return redirect()->route('Knowledge.detail', ['id' => $postId])->with('flashMessage', '投稿中にエラーが発生しました。');
        }
    }
}
