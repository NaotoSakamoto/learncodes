<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LearncodesController extends Controller
{
    public function index()
    {
        $data = [];
        if (\Auth::check()) {
            // 認証済みユーザ（閲覧者）を取得
            $user = \Auth::user();
            // ユーザとフォロー中ユーザの投稿の一覧を作成日時の降順で取得
            $learncodes = $user->feed_learncodes()->orderBy('created_at', 'desc')->paginate(10);

            $data = [
                'user' => $user,
                'learncodes' => $learncodes,
            ];
        }

        // Welcomeビューでそれらを表示
        return view('welcome', $data);
    }
    
    public function store(Request $request)
    {
        // バリデーション
        $request->validate([
            'title' => 'required|max:255',
            'language' => 'required|max:255',
            'content' => 'required|max:255',
        ]);

        // 認証済みユーザ（閲覧者）の投稿として作成（リクエストされた値をもとに作成）
        $request->user()->learncodes()->create([
            'radioGrp01' => $request->radioGrp01,
            'title' => $request->title,
            'language' => $request->language,
            'content' => $request->content,
        ]);

        // 前のURLへリダイレクトさせる
       return back();
    }
    
    public function destroy($id)
    {
        // idの値で投稿を検索して取得
        $learncode = \App\Learncode::findOrFail($id);

        // 認証済みユーザ（閲覧者）がその投稿の所有者である場合は、投稿を削除
        if (\Auth::id() === $learncode->user_id) {
            $learncode->delete();
        }

        // 前のURLへリダイレクトさせる
        return back();
    }
}
