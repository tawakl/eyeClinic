<div class="form-group {{$attributes['col-class'] ??''}}">
    <label class="col-6 form-control-label">{{ @$attributes['label'] }}
        <span class="tx-danger" style="color: red">{{ (@$attributes['required'])?'*':'' }} {{ (@$attributes['stared'])?'*':'' }}</span>
    </label>
    <div class="col-12">
        @php
            $attributes['style']=@$attributes['style'];
            $attributes['multiple'] = 'multiple';
        @endphp

        <select name="{{ $name }}[]" class="form-control select2" {{ @$attributes['multiple'] ?? '' }} {{ @$attributes['style'] ?? '' }}>
            @foreach($options as $key => $label)
                <option value="{{ $key }}"
                    {{ in_array($key, (array) @$row->$name) ? 'selected' : (in_array($key, old($name, [])) ? 'selected' : '') }}>
                    {{ $label }}
                </option>
            @endforeach
        </select>

        @if(@$errors)
            @foreach($errors->get($name) as $message)
                <span class='help-inline text-danger'>{{ $message }}</span>
            @endforeach
        @endif
    </div>
</div>
