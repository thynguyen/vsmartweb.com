<div class="form-group form-group-sm">
    <label class="" for="page_focus_keyword">Focus Keyword</label>
    <input type="text" name="focus_keyword" value="{{$record->focus_keyword}}"
           placeholder="e.g. Travel"
           class="form-control">

    @if($errors->has('page.robot_index'))
        <span class="form-control-feedback">
                <strong>{{ $errors->first('page.focus_keyword') }}</strong>
            </span>
    @endif
</div>
@if(!empty($keywordAnalysis) && !empty($record->id))
        @if(isset($keywordAnalysis['good']) && !empty($keywordAnalysis['good']))
                <div class="card border-success">
                    <div class="card-header bg-transparent border-success">
                        <i class="fa fa-check-square text-success"></i> Good
                    </div>
                    <div class="card-body text-small">
                        <ul class="list-group">
                            @foreach($keywordAnalysis['good'] as $msg)
                                <li class="list-group-item">{{$msg}}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
        @endif
        @if(isset($keywordAnalysis['warnings']) && !empty($keywordAnalysis['warnings']))
                <div class="card border-warning">
                    <div class="card-header bg-transparent border-warning">
                        <i class="fa fa-warning text-warning"></i> Warnings
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            @foreach($keywordAnalysis['warnings'] as $msg)
                                <li class="list-group-item">{!!$msg!!}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
        @endif
        @if(isset($keywordAnalysis['errors']) && !empty($keywordAnalysis['errors']))
                <div class="card border-danger">
                    <div class="card-header  bg-transparent border-danger">
                        <i class="fa fa-warning text-danger"></i> Errors
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            @foreach($keywordAnalysis['errors'] as $msg)
                                <li class="list-group-item">{{$msg}}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
        @endif
@endif