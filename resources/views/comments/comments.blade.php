<div class='row'>
    <div class="col-sm-8">
         {!! Form::model($content, ['route' => ['comment.store', $content->learncode_id], 'method' => 'post']) !!}
             <div class="form-group">
                    {!! Form::textarea('content', null, ['class' => 'form-control', 'rows' => '3']) !!}
                    {!! Form::submit('Comment', ['class' => 'btn btn-success']) !!}
             </div>
         {!! Form::close() !!}
    </div>
</div>