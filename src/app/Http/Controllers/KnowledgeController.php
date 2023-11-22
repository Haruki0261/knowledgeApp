<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class KnowledgeController extends Controller
{
    /**
     * 投稿一覧画面（top画面に遷移）
     *
     * @return View
     */
    public function index(): View
    {

        return view('top.index');
    }
}
