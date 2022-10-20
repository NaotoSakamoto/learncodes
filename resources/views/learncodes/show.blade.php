@extends('layouts.app')

@section('content')
    <div class="row">
        <aside class="col-sm-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ Auth::user()->name }}</h3>
                </div>
                <div class="card-body">
                    {{-- ユーザのメールアドレスをもとにGravatarを取得して表示 --}}
                    <img class="rounded img-fluid" src="{{ Gravatar::get(Auth::user()->email, ['size' => 500]) }}" alt="">
                </div>
            </div>
        </aside>
        <div class="media mb-3">
                {{-- 投稿の所有者のメールアドレスをもとにGravatarを取得して表示 --}}
                <img class="mr-2 rounded" src="{{ Gravatar::get($learncode->user->email, ['size' => 70]) }}" alt="">
                <div class="media-body">
                    <div>
                        {{-- 投稿の所有者のユーザ詳細ページへのリンク --}}
                        {!! link_to_route('users.show', $learncode->user->name, ['user' => $learncode->user->id], ['style' => 'font-size:large']) !!}
                        <span class="text-muted" style="font-size:large;">posted at {{ $learncode->created_at }}</span>
                    </div>
                    <div>
                        {{-- 投稿内容 --}}
                        {{-- 一覧画面で同じものを表示 --}}
                        @if (($learncode->radioGrp01) == 1)
                            <p class="mb-0" style="font-weight:bold; font-size:large;">学習記録</p>
                        @elseif (($learncode->radioGrp01) == 2)
                            <p class="mb-0" style="font-weight:bold; font-size:large;">質問</p>
                        @endif
                        <p class="mb-0" style="font-weight:bold; font-size:large;">タイトル：{!! nl2br(e($learncode->title)) !!}</p>
                        <p class="mb-0" style="font-size:large;">言語：{!! nl2br(e($learncode->language)) !!}</p>
                        <p class="mb-0" style="font-size:large;">本文：{!! nl2br(e($learncode->content)) !!}</p>
                    </div>
                    {{-- 以下一覧画面より移動 --}}
                    <div style="display:flex; margin-top:10px">
                        <div style="margin-right:3px">
                            @if (Auth::id() == $learncode->user_id)
                                {{-- 投稿削除ボタンのフォーム --}}
                                {!! Form::open(['route' => ['learncodes.destroy', $learncode->id], 'method' => 'delete']) !!}
                                    {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                {!! Form::close() !!}
                            @endif
                        </div>
                        <div style="margin-right:3px">
                            @if (Auth::user()->is_favoriting($learncode->id))
                                {{-- お気に入り解除ボタンのフォーム --}}
                                {!! Form::open(['route' => ['favorites.unfavorite', $learncode->id], 'method' => 'delete']) !!}
                                    {!! Form::submit('Unfavorite', ['class' => 'btn btn-danger']) !!}
                                {!! Form::close() !!}
                            @else
                                {{-- お気に入りボタンのフォーム --}}
                                {!! Form::open(['route' => ['favorites.favorite', $learncode->id]]) !!}
                                    {!! Form::submit('Favorite', ['class' => 'btn btn-secondary']) !!}
                                {!! Form::close() !!}
                            @endif
                        </div>
                        {{-- 編集ページへのリンク --}}
                        {!! link_to_route('learncodes.edit', 'Edit', ['learncode' => $learncode->id], ['class' => 'btn btn-light']) !!}
        </div>
    </div>
@endsection