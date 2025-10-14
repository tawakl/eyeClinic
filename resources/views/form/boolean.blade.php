<div class="form-group {{ $attributes['col-class'] ?? '' }}">
    <label class="control-label col-md-2 col-sm-2 col-xs-12">
        {{ @$attributes['label'] }}
        <span class="tx-danger" style="color: red">
            {{ (@$attributes['required'])?'*':'' }} {{ (@$attributes['stared'])?'*':'' }}
        </span>
    </label>
    <div class="col-sm-8 mg-t-10 mg-sm-t-0">
        <div class="row mg-t-10">
            <div class="col-lg-4">
                @php
                    $attributes['class'] = '';
                @endphp
                <label class="rdiobox">
                    <input type="radio" name="{{ $name }}" value="1"
                        {{ (old($name, isset($value) ? $value : null) == 1) ? 'checked' : '' }}
                        {{ @$attributes['required'] ? 'required' : '' }}>
                    <span>{{ trans('app.Yes') }}</span>
                </label>
            </div><!-- col-3 -->
            <div class="col-lg-4">
                <label class="rdiobox">
                    <input type="radio" name="{{ $name }}" value="0"
                        {{ (old($name, isset($value) ? $value : null) == 0) ? 'checked' : '' }}
                        {{ @$attributes['required'] ? 'required' : '' }}>
                    <span>{{ trans('app.No') }}</span>
                </label>
            </div><!-- col-3 -->

            @if($errors->has($name))
                <div class="col-12">
                    @foreach($errors->get($name) as $message)
                        <span class='help-inline text-danger'>{{ $message }}</span>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
