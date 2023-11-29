<?php

namespace App\Http\Controllers;

use App\Models\Posts;
use App\Models\PostImages;
use Exception;
use Illuminate\Contracts\View\View;
use App\Http\Requests\PostRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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
     * @return　RedirectResponse
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
            // それを一気にINSERTする。
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
     * @param integer $postId
     *
     * @return View
     */
    public function KnowledgeDetail(int $postId): View
    {
        $posts = $this->posts->getPost($postId);
        $postImages = $this->postImages->getPostImage($postId);

        return view('post.detail', compact('posts', 'postImages'));
    }
}
