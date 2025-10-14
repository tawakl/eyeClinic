<div class="form-group {{$attributes['col-class'] ??''}}">
    <div class="row">
        <label class="control-label col-6">{{ @$attributes['label'] }} <span
                    class="tx-danger red" style="color: red">{{ (@$attributes['required'])?'*':'' }}</span>
        </label>
        <div class="col-12">
            <div class="row mg-t-10">
                @foreach($options as $option)
                    <div class="col-lg-3">
                        <label class="rdiobox">
                            {!! Form::radio($name,$option['value'],null,$attributes) !!}
                            <span>{{$option['label']}} </span>
                        </label>
                    </div><!-- col-3 -->

                @endforeach
                @if(@$errors)

                    @php
                        $error_name =(isset($error_name))?$error_name:$name;
                    @endphp

                    @foreach($errors->get($error_name) as $message)
                        <span class='help-inline text-danger'>{{ $message }}</span>
                    @endforeach

                @endif
            </div>
        </div>
    </div>
</div>



