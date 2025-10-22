<div class="row">

    {{-- Title --}}
    @php
        $attributes = [
            'class' => 'form-control',
            'col-class' => "col-md-6",
            'label' => trans('publication.title'),
            'placeholder' => trans('publication.title')
        ];
    @endphp
    @include('form.input', [
        'type' => 'text',
        'name' => 'title',
        'value' => $row->title ?? null,
        'attributes' => $attributes
    ])

    {{-- Category --}}
    @php
        $attributes = [
            'class' => 'form-control',
            'col-class' => "col-md-6",
            'label' => trans('publication.category'),
            'placeholder' => trans('publication.category')
        ];
    @endphp
    @include('form.input', [
        'type' => 'text',
        'name' => 'category',
        'value' => $row->category ?? null,
        'attributes' => $attributes
    ])



    {{-- Published At --}}
    @php
        $attributes = [
            'class' => 'form-control',
            'col-class' => "col-md-6",
            'label' => trans('publication.published_year'),
            'placeholder' => 'YYYY'
        ];
    @endphp
    @include('form.input', [
    'type' => 'number',
    'name' => 'published_year',
    'value' => $row->published_year ?? null,
    'attributes' => $attributes
    ])

    {{-- Description --}}
    @php
        $attributes = [
            'class' => 'form-control',
            'col-class' => "col-md-12",
            'label' => trans('publication.description'),
            'placeholder' => trans('publication.description')
        ];
    @endphp
    @include('form.input', [
        'type' => 'textarea',
        'name' => 'description',
        'value' => $row->description ?? null,
        'attributes' => $attributes
    ])
</div>
