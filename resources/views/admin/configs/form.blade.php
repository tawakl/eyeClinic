@php
    $fields = [
        'clinic_name' => trans('config.clinic_name'),
        'clinic_address' => trans('config.clinic_address'),
        'clinic_phone' => trans('config.clinic_phone'),
        'clinic_email' => trans('config.clinic_email'),
        'clinic_latitude' => trans('config.clinic_latitude'),
        'clinic_longitude' => trans('config.clinic_longitude'),
    ];

$weekDays = [
    'saturday' => trans('config.saturday'),
    'sunday' => trans('config.sunday'),
    'monday' => trans('config.monday'),
    'tuesday' => trans('config.tuesday'),
    'wednesday' => trans('config.wednesday'),
    'thursday' => trans('config.thursday'),
    'friday' => trans('config.friday'),
];
@endphp

{{-- Clinic Info Fields --}}
<div class="row">
    @foreach($fields as $key => $label)
        <div class="col-md-6 mb-3">
            <label for="{{ $key }}">{{ $label }}</label>
            <input
                type="text"
                name="{{ $key }}"
                id="{{ $key }}"
                value="{{ old($key, $row[$key] ?? null) }}"
                class="form-control"
                placeholder="{{ $label }}"
            >
            @error($key)
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
    @endforeach
</div>

<hr>

{{-- Working Days --}}
<div class="row">
    <label class="col-12 mb-2">{{ trans('config.Working Days & Hours') }}</label>

    @foreach($weekDays as $day)
        @php
            $workingDay = $working_days[$day] ?? ['day'=> false, 'from_time' => null, 'to_time' => null];
        @endphp
        <div class="col-12 mb-3 day-block p-2 border rounded">
            <div class="form-check mb-2">
                <input type="checkbox" class="form-check-input day-checkbox" id="checkbox_{{ $day }}"
                       name="working_days[{{ $day }}][day]"
                       value="1"
                    {{ old("working_days.$day.day", $workingDay['day'] ?? false) ? 'checked' : '' }}>
                <label class="form-check-label fw-bold" for="checkbox_{{ $day }}">{{ $day }}</label>
            </div>

            <div class="time-inputs row g-2 align-items-center" style="{{ old("working_days.$day.day", $workingDay['day'] ?? false) ? '' : 'display:none;' }}">
                <div class="col-auto">
                    <label class="mb-0">{{ trans('config.From') }}</label>
                    <input type="time" class="form-control"
                           name="working_days[{{ $day }}][from_time]"
                           value="{{ old("working_days.$day.from_time", $workingDay['from_time'] ?? '') }}">
                </div>
                <div class="col-auto">
                    <label class="mb-0">{{ trans('config.To') }}</label>
                    <input type="time" class="form-control"
                           name="working_days[{{ $day }}][to_time]"
                           value="{{ old("working_days.$day.to_time", $workingDay['to_time'] ?? '') }}">
                </div>
            </div>
        </div>
    @endforeach
</div>

@push('js')
    <script>
        $(document).ready(function() {
            // Toggle From/To inputs when checkbox is clicked
            $('.day-checkbox').on('change', function() {
                const container = $(this).closest('.day-block');
                if ($(this).is(':checked')) {
                    container.find('.time-inputs').slideDown();
                } else {
                    container.find('.time-inputs').slideUp();
                    container.find('input[type=time]').val('');
                }
            });
        });
    </script>
@endpush
