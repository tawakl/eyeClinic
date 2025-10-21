<div class="row">

    {{-- From Date --}}
    @php
        $attributes = [
            'class' => 'form-control',
            'col-class' => "col-md-4",
            'label' => trans('clinic_working_days.from_date') ,
        ];
    @endphp
    @include('form.input', [
        'type' => 'date',
        'name' => 'from_date',
        'value' => old('from_date', $row->from_date ?? ''),
        'attributes' => $attributes
    ])

    {{-- To Date --}}
    @php
        $attributes = [
            'class' => 'form-control',
            'col-class' => "col-md-4",
            'label' => trans('clinic_working_days.to_date') ,
        ];
    @endphp
    @include('form.input', [
        'type' => 'date',
        'name' => 'to_date',
        'value' => old('to_date', $row->to_date ?? ''),
        'attributes' => $attributes
    ])

    {{-- Reason --}}
    @php
        $attributes = [
            'class' => 'form-control',
            'col-class' => "col-md-4",
            'label' => trans('clinic_working_days.reason') ,
            'placeholder' => 'e.g. Holiday, Maintenance, etc.'
        ];
    @endphp
    @include('form.input', [
        'type' => 'text',
        'name' => 'reason',
        'value' => old('reason', $row->reason ?? ''),
        'attributes' => $attributes
    ])
</div>
