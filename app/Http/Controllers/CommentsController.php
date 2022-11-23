<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommentsController extends Controller
{
    public function store(Request $request){
        // バリデーション
        $request->validate([
            'content' => 'required|max:500',
        ]);

        // 認証済みユーザ（閲覧者）の投稿として作成（リクエストされた値をもとに作成）
        $request->user()->comments()->create([
            'learncode_id' => array_keys($request->query())[0],
            'comment' => "'" . $request->content . "'"
        ]);

        
        // 前のURLへリダイレクトさせる
        return back();
    }
}
