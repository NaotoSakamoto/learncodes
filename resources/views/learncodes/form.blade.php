{!! Form::open(['route' => 'learncodes.store']) !!}
    <div class="form-group">
        <div class="col-md-6">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" id="inlineRadio01" name="radioGrp01" value="1">
                <label class="form-check-label" for="inlineRadio01">学習記録</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" id="inlineRadio02" name="radioGrp01" value="2">
                <label class="form-check-label" for="inlineRadio02">質問</label>
            </div>
        </div>
        タイトル{!! Form::textarea('title', null, ['class' => 'form-control', 'rows' => '1']) !!}
        言語{!! Form::textarea('language', null, ['class' => 'form-control', 'rows' => '1']) !!}
        本文（学習時間／質問内容）{!! Form::textarea('content', null, ['class' => 'form-control', 'rows' => '2']) !!}
        {!! Form::submit('Post', ['class' => 'btn btn-primary btn-block']) !!}
    </div>
{!! Form::close() !!}