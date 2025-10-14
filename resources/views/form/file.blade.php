<div class="form-group {{ $attributes['col-class'] ?? '' }}">
    <div class="mb-1">
        <label for="{{ $attributes['id'] ?? $name }}" class="form-label">
            {{ @$attributes['label'] }}
            <span class="{{ (@$attributes['required'])?'required':'' }} text-danger" style="color: red">
                {{ (@$attributes['required'])?'*':'' }} {{ (@$attributes['stared'])?'*':'' }}
            </span>
        </label>

        <!-- استبدال Form::file بـ input عادي -->
        <input type="file" name="{{ $name }}" id="{{ $attributes['id'] ?? $name }}" class="form-control" {{ (@$attributes['required'])?'required':'' }}>

        <small class="text-muted">{{ @$attributes['help'] }}</small>

        @if(isset($attributes['dimensions']))
            <br>
            <small class="text-capitalize fw-bolder">
                note: its recommended to upload image with dimensions <span class="text-danger">
                {{ @$attributes['dimensions'] }}
                </span>
            </small>
        @endif

        <br>

        <output id="{{ $name }}_listImage" class="{{ $name }}_listImage">
            @if(isset($errors) && !$errors->isEmpty())
                @foreach($errors->get($name) as $message)
                    <span class='help-inline text-danger'>{{ $message }}</span>
                @endforeach
                <br>
            @endif

            <!-- عرض الملف الحالي -->
            @if(isset($value))
                @if(@$attributes['file_type'] == 'attachment' )
                    {!! viewFile($value) !!}
                @elseif(@$attributes['file_type'] == 'video')
                    {!! viewVideo($value) !!}
                @else
                    {!! viewImage(img: $value, type: App\Modules\BaseApp\Enums\S3Enums::LARGE) !!}
                @endif
            @elseif(old($name))
                <!-- عرض الصورة القديمة في حال وجودها -->
                @if(@$attributes['file_type'] == 'attachment')
                    {!! viewFile(old($name)) !!}
                @elseif(@$attributes['file_type'] == 'video')
                    {!! viewVideo(old($name)) !!}
                @else
                    {!! viewImage(img: old($name), type: App\Modules\BaseApp\Enums\S3Enums::LARGE) !!}
                @endif
            @endif
        </output>
    </div>
</div>

@push('js')
    <script>
        function handleFileSelect(evt) {
            var files = evt.target.files;
            console.log(files);

            // Loop through the FileList and render image files as thumbnails.
            for (var i = 0, f; f = files[i]; i++) {
                // Only process image files.
                if (!f.type.match('image.*')) {
                    continue;
                }

                var reader = new FileReader();

                // Closure to capture the file information.
                reader.onload = (function (theFile) {
                    return function (e) {
                        // Render thumbnail.
                        var span = document.createElement('span');
                        span.innerHTML =
                            [
                                '<img style="height: 200px; width:200px; border: 1px solid #000; margin: 5px" src="',
                                e.target.result,
                                '" title="', escape(theFile.name),
                                '"/>'
                            ].join('');
                        $('.{{ $name }}_listImage img').remove();
                        console.log(span);
                        document.getElementById('{{ $name }}_listImage').insertBefore(span, null);
                    };
                })(f);

                // Read in the image file as a data URL.
                reader.readAsDataURL(f);
            }
        }

        document.getElementById('{{ $name }}').addEventListener('change', handleFileSelect, false);
    </script>
@endpush
