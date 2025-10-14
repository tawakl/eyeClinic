<div class="form-group {{ $attributes['col-class'] ?? '' }}">
    <label class="control-label col-6" for="exampleFormControlSelect1">
        {{ @$attributes['label'] }}
        <span class="tx-danger" style="color: red">
            {{ (@$attributes['required'])?'*':'' }} {{ (@$attributes['stared'])?'*':'' }}
        </span>
    </label>
    <div class="col-12">
        @php
            $attributes['autocomplete'] = 'off';
        @endphp
        <select name="{{ $name }}" id="exampleFormControlSelect1" class="form-control" {{ @$attributes['required'] ? 'required' : '' }}>
            @foreach($options as $key => $value)
                <option value="{{ $key }}"
                    {{ (old($name, @$row->$name) == $key) ? 'selected' : '' }}>
                    {{ $value }}
                </option>
            @endforeach
        </select>

        @php
            $name = (isset($error_name)) ? $error_name : $name;
        @endphp

        @if(@$errors)
            <ul class="parsley-errors-list filled">
                @foreach($errors->get($name) as $message)
                    <li class="parsley-required text-danger">{{ $message }}</li>
                @endforeach
            </ul>
        @endif
    </div>
</div>
