<div class="row">

    {{-- Caption --}}
    @php
        $attributes = [
            'class' => 'form-control',
            'col-class' => "col-md-6",
            'label' => trans('gallery.caption'),
            'placeholder' => trans('gallery.caption')
        ];
    @endphp
    @include('form.input', [
        'type' => 'text',
        'name' => 'caption',
        'value' => $row->caption ?? null,
        'attributes' => $attributes
    ])

    {{-- Image Upload --}}
    @php
        $attributes = [
            'class' => 'form-control',
            'col-class' => "col-md-6 text-center",
            'label' => trans('gallery.image'),
            'accept' => 'image/png,image/jpg,image/jpeg,image/webp'
        ];
    @endphp
    @include('form.file', [
        'name' => 'image',
        'value' => $row->image_url ?? null,
        'attributes' => $attributes
    ])

</div>

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const oldImageUrl = @json($row->image_url ?? null);

            // لقطة موجهة داخل الكومبوننت بس
            const fileWrapper = document.querySelector('[name="image"]')?.closest('.form-group');
            const previewImg = fileWrapper ? fileWrapper.querySelector('img') : null;

            if (oldImageUrl && previewImg) {
                previewImg.src = oldImageUrl;
            }

            const input = document.querySelector('input[name="image"]');
            if (input && previewImg) {
                input.addEventListener('change', function (e) {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = ev => previewImg.src = ev.target.result;
                        reader.readAsDataURL(file);
                    }
                });
            }
        });
    </script>
@endpush
