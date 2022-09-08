{!! Form::open(['route' => 'learncodes.store']) !!}
    <div class="form-group">
        タイトル{!! Form::textarea('content', null, ['class' => 'form-control', 'rows' => '1']) !!}
        言語{!! Form::textarea('content', null, ['class' => 'form-control', 'rows' => '1']) !!}
        学習時間{!! Form::textarea('content', null, ['class' => 'form-control', 'rows' => '2']) !!}
        {!! Form::submit('Post', ['class' => 'btn btn-primary btn-block']) !!}
    </div>
{!! Form::close() !!}