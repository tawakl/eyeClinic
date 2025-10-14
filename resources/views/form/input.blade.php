<div class="form-group {{ $attributes['col-class'] ?? '' }}">
    <div class="row">
        <label class="control-label col-6" for="{{ $name }}">
            {{ @$attributes['label'] }}
            <span class="tx-danger" style="color: red">{{ (@$attributes['required'])?'*':'' }} {{ (@$attributes['stared'])?'*':'' }}</span>
        </label>
        <div class="col-12">
            <input type="{{ $type }}" name="{{ $name }}" id="{{ $name }}" class="form-control" placeholder="{{ @$attributes['placeholder'] }}"
                   value="{{ old($name, $value ?? $row->$name ?? '') }}" {{ (@$attributes['required'])?'required':'' }}>
            @if(@$errors)
                <ul class="parsley-errors-list filled">
                    @foreach($errors->get($name) as $message)
                        <li class="parsley-required text-danger">{{ $message }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>
