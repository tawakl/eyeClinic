<div class="form-group {{$attributes['col-class'] ??''}}">
    <label class="control-label col-6">{{ @$attributes['label'] }}
    </label>
    <div class="col-12">
        <div class="custom-file">
            {!! Form::file($name,$attributes)!!}
            <output id="listImage" class="listImage">
                @if(!$errors->isEmpty())
                    @foreach($errors->get($name) as $message)
                        <span class='help-inline text-danger'>{{ $message }}</span>
                    @endforeach
                    <br>
                @endif

                @if(isset($value))
                    {!! viewVideo(vid:$value) !!}
                @endif
            </output>


        </div>

    </div>
</div>
@push('js')
    <script>
        function handleFileSelect(evt) {
            var files = evt.target.files;

            // Loop through the FileList and render image files as thumbnails.
            for (var i = 0, f; f = files[i]; i++) {
                const videoURL = URL.createObjectURL(f);
                var span = document.createElement('span');
                span.innerHTML =
                    [
                        '<video width="200" height="200" controls> <source src = "', videoURL, '" type = "video/mp4" >Your browser does not support the video tag. </video>'
                    ].join('');
                $('.listImage video').remove();
                document.getElementById('listImage').insertBefore(span, null);
            }
        }

        document.getElementById('{{ $name }}').addEventListener('change', handleFileSelect, false);
    </script>
@endpush
