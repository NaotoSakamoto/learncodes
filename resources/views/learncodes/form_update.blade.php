{!! Form::open(['route' => ['learncodes.update', $learncode->id], 'method' => 'put']) !!}
    <div class="form-group">
        {!! Form::textarea('content', null, ['class' => 'form-control', 'rows' => '2']) !!}
        {!! Form::submit('Repost', ['class' => 'btn btn-primary btn-block']) !!}
    </div>
{!! Form::close() !!}