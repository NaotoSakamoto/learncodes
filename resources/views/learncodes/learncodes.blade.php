@if (count($learncodes) > 0)
    <ul class="list-unstyled">
        @foreach ($learncodes as $learncode)
            <li class="media mb-3">
                {{-- 投稿の所有者のメールアドレスをもとにGravatarを取得して表示 --}}
                <img class="mr-2 rounded" src="{{ Gravatar::get($learncode->user->email, ['size' => 50]) }}" alt="">
                <div class="media-body">
                    <div>
                        {{-- 投稿の所有者のユーザ詳細ページへのリンク --}}
                        {!! link_to_route('users.show', $learncode->user->name, ['user' => $learncode->user->id]) !!}
                        <span class="text-muted">posted at {{ $learncode->created_at }}</span>
                    </div>
                    <div>
                        {{-- 投稿内容 --}}
                        {{-- 詳細画面で同じものを表示 --}}
                        @if (($learncode->radioGrp01) == 1)
                            <p class="mb-0">学習記録</p>
                        @elseif (($learncode->radioGrp01) == 2)
                            <p class="mb-0">質問</p>
                        @endif
                        <p class="mb-0">タイトル：{!! nl2br(e($learncode->title)) !!}</p>
                        <p class="mb-0">言語：{!! nl2br(e($learncode->language)) !!}</p>
                        <p class="mb-0">本文：{!! nl2br(e($learncode->content)) !!}</p>
                    </div>
                    
                    {{-- 以下詳細画面に移動検討 --}}
                    <div style="display:flex">
                        <div style="margin-right:3px">
                            @if (Auth::id() == $learncode->user_id)
                                {{-- 投稿削除ボタンのフォーム --}}
                                {!! Form::open(['route' => ['learncodes.destroy', $learncode->id], 'method' => 'delete']) !!}
                                    {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                                {!! Form::close() !!}
                            @endif
                        </div>
                        <div style="margin-right:3px">
                            @if (Auth::user()->is_favoriting($learncode->id))
                                {{-- お気に入り解除ボタンのフォーム --}}
                                {!! Form::open(['route' => ['favorites.unfavorite', $learncode->id], 'method' => 'delete']) !!}
                                    {!! Form::submit('Unfavorite', ['class' => 'btn btn-danger btn-sm']) !!}
                                {!! Form::close() !!}
                            @else
                                {{-- お気に入りボタンのフォーム --}}
                                {!! Form::open(['route' => ['favorites.favorite', $learncode->id]]) !!}
                                    {!! Form::submit('Favorite', ['class' => 'btn btn-secondary btn-sm']) !!}
                                {!! Form::close() !!}
                            @endif
                        </div>
                        {{-- 編集ページへのリンク --}}
                        {!! link_to_route('learncodes.edit', 'Edit', ['learncode' => $learncode->id], ['class' => 'btn btn-light btn-sm']) !!}
                        {{-- 詳細ページへのリンク --}}
                        {!! link_to_route('learncodes.show', 'Show', ['learncode' => $learncode->id], ['class' => 'btn btn-info btn-sm']) !!}
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
    {{-- ページネーションのリンク --}}
    {{ $learncodes->links() }}
@endif