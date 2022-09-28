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
        <div class="col-sm-8">
            @if (Auth::id() == Auth::user()->id)
                {!! Form::model($learncode, ['route' => ['learncodes.update', $learncode->id], 'method' => 'put']) !!}
                    <div class="form-group">
                        {!! Form::textarea('title', null, ['class' => 'form-control', 'rows' => '1']) !!}
                        {!! Form::textarea('language', null, ['class' => 'form-control', 'rows' => '1']) !!}
                        {!! Form::textarea('content', null, ['class' => 'form-control', 'rows' => '2']) !!}
                        {!! Form::submit('Repost', ['class' => 'btn btn-primary btn-block']) !!}
                    </div>
                {!! Form::close() !!}
            @endif
        </div>
    </div>
@endsection
