<div class="row">
    @foreach($rows as $index => $row)
        <div class="col-12 mb-4">
            <div class="border rounded p-3 shadow-sm bg-light day-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="mb-0 text-capitalize">
                        <i class="fa fa-calendar-day me-2 text-primary"></i>
                        {{ trans('clinic_working_days.' . strtolower($row->day)) }}
                    </h6>

                    <div class="form-check form-switch">
                        <input type="hidden" name="working_days[{{ $index }}][day]" value="{{ $row->day }}">
                        <input type="checkbox" class="form-check-input toggle-day" id="day_active_{{ $index }}"
                               name="working_days[{{ $index }}][is_active]"
                               value="1" {{ $row->is_active ? 'checked' : '' }}>
                        <label class="form-check-label" for="day_active_{{ $index }}">
                            {{ trans('clinic_working_days.active') }}
                        </label>
                    </div>
                </div>

                <div class="day-fields {{ $row->is_active ? '' : 'd-none' }}">
                    <div class="row gy-3">
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">{{ trans('clinic_working_days.from_time') }}</label>
                            <input type="time" name="working_days[{{ $index }}][from_time]" value="{{ $row->from_time }}" class="form-control">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-semibold">{{ trans('clinic_working_days.to_time') }}</label>
                            <input type="time" name="working_days[{{ $index }}][to_time]" value="{{ $row->to_time }}" class="form-control">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-semibold">{{ trans('clinic_working_days.break_from') }}</label>
                            <input type="time" name="working_days[{{ $index }}][break_from]" value="{{ $row->break_from }}" class="form-control">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-semibold">{{ trans('clinic_working_days.break_to') }}</label>
                            <input type="time" name="working_days[{{ $index }}][break_to]" value="{{ $row->break_to }}" class="form-control">
                        </div>

                        <div class="col-md-3 mt-2">
                            <label class="form-label fw-semibold">{{ trans('clinic_working_days.slot_duration') }}</label>
                            <input type="number" name="working_days[{{ $index }}][slot_duration]" value="{{ $row->slot_duration }}" class="form-control" min="5" step="5">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.toggle-day').forEach(toggle => {
                toggle.addEventListener('change', function () {
                    const card = this.closest('.day-card');
                    const fields = card.querySelector('.day-fields');
                    if (this.checked) {
                        fields.classList.remove('d-none');
                    } else {
                        fields.classList.add('d-none');
                        fields.querySelectorAll('input[type="time"], input[type="number"]').forEach(inp => inp.value = '');
                    }
                });
            });
        });
    </script>
@endpush
