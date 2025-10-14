<div class="form-group {{ $attributes['col-class'] ?? '' }}">
    <label class="control-label col-6" for="{{ $attributes['id'] ?? $name }}">
        {{ @$attributes['label'] }}
        <span class="tx-danger" style="color: red">
            {{ (@$attributes['required'])?'*':'' }} {{ (@$attributes['stared'])?'*':'' }}
        </span>
    </label>

    @php
        if (isset($attributes['required'])) {
            unset($attributes['required']);
        }
    @endphp

    <div class="col-12">
        <!-- استبدال Form::password بـ input عادي -->
        <input type="password" name="{{ $name }}" id="{{ $attributes['id'] ?? $name }}" class="form-control" placeholder="{{ @$attributes['placeholder'] }}" {{ (@$attributes['required'])?'required':'' }}>

        @if(@$errors)
            @php
                $name = (isset($error_name)) ? $error_name : $name;
            @endphp
            <ul class="parsley-errors-list filled">
                @foreach(@$errors->get($name) as $message)
                    <li class="parsley-required text-danger">{{ @$message }}</li>
                @endforeach
            </ul>
        @endif
    </div>
</div>
