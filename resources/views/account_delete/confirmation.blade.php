@extends('layouts.app')

@section('content')
    <div class="center jumbotron">
        <div class="text-center">
            <h2>Do you really want to delete this account?</h2>
            {{-- アカウント削除 Yes ボタンのフォーム --}}
            {!! Form::open(['route' => ['users.destroy', $user->id], 'method' => 'delete']) !!}
                {!! Form::submit('Yes', ['class' => "btn btn-danger btn-lg"]) !!}
            {!! Form::close() !!}

            {{-- アカウント削除 No ボタンのリンク --}}
            <a href='/' class="btn btn-light btn btn-lg">No</a>
        </div>
    </div>
@endsection