<div class="card">
    <div class="card-body p-0">
        <div class="m-3 d-flex justify-content-between align-items-center">
            <h4 class="card-title mb-0">{!!$group->title!!}</h4>
            <button type="button" class="btn btn-sm btn-primary" onclick="addslider('{!!$group->id!!}');"><i class="fas fa-image mr-1"></i>{!!transmod('sliders::AddSlider')!!}</button>
        </div>
        <table class="table table-responsive-sm table-striped mb-0">
            <tbody>
                @foreach($group->slider as $slider)
                <tr id="slider{!!$slider->id!!}">
                    <td width="100">
                        <select class="form-control" id="idweight_{{$slider['id']}}" onchange="changesliderweight('{{$slider['id']}}','{!!$group->id!!}','idweight_{{$slider['id']}}')">
                            @for($i=1;$i<=$numdoc;$i++)
                            <option value="{!!$i!!}" {{($i==$slider['weight'])?'selected="selected"':''}}>{!!$i!!}</option>
                            @endfor
                        </select>
                    </td>
                    <td width="100"><img src="{!!$slider->thumb!!}" class=""></td>
                    <td>
                        <strong>{!!$slider->title!!}</strong><br>{!!$slider->description!!}
                        @if($slider->link)
                        <hr class="my-1"><div class="d-flex justify-content-between align-items-center">{!!$slider->link!!}<a href="{!!$slider->link!!}" target="_black"><i class="fal fa-external-link-alt"></i></a></div>
                        @endif
                    </td>
                    <td width="100">
                        <div class="button">
                            <button type="button" class="btn btn-sm btn-primary" onclick="addslider('{!!$group->id!!}','{!!$slider->id!!}');"><i class="fas fa-pen"></i></button>
                            <button type="button" class="btn btn-sm btn-danger" onclick="delslider('{!!$slider->id!!}','{!!$group->id!!}');"><i class="fas fa-trash-alt"></i></button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>