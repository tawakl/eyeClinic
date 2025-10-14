<div class="row justify-content-center align-items-center">

    @php
        $attributes = [
            'class' => 'form-control',
            'col-class' => "col-md-6 d-flex align-items-center",
            'label' => trans('gallery.caption'),
            'placeholder' => trans('gallery.caption')
        ];
    @endphp
    <div class="{{ $attributes['col-class'] }}">
        <label for="caption" class="form-control-label mb-0 me-2" style="white-space: nowrap;">
            {{ trans('gallery.caption') }}:
        </label>
        <input type="text"
               name="caption"
               id="caption"
               class="{{ $attributes['class'] }}"
               placeholder="{{ $attributes['placeholder'] }}"
               value="{{ $row->caption ?? '' }}">
    </div>

    <div class="form-group col-md-12 text-center mt-4">
        <label for="image" class="form-control-label d-block mb-3">
            {{ trans('gallery.image') }}
        </label>

        <div class="position-relative d-inline-block">
            <img id="imagePreview"
                 src="{{ $row->image_url ?? '/assets/img/default-user.png' }}"
                 alt="Preview"
                 class="rounded-circle border shadow-sm"
                 style="width: 220px; height: 220px; object-fit: cover; cursor: pointer; transition: transform 0.2s ease-in-out;">

            <input type="file" id="image" name="image"
                   accept="image/png,image/jpg,image/jpeg,image/webp"
                   class="d-none">
        </div>

        <p class="text-muted mt-3" style="font-size: 13px;">
            {{ trans('gallery.click_to_change') }}
        </p>
    </div>
</div>

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const imageInput = document.getElementById('image');
            const imagePreview = document.getElementById('imagePreview');

            imagePreview.addEventListener('click', () => imageInput.click());

            imageInput.addEventListener('change', function (event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        imagePreview.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            });

            imagePreview.addEventListener('mouseover', () => {
                imagePreview.style.transform = 'scale(1.05)';
            });
            imagePreview.addEventListener('mouseout', () => {
                imagePreview.style.transform = 'scale(1)';
            });
        });
    </script>
@endpush
