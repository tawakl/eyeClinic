
<ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5" >
    <li class="breadcrumb-item text-sm" >
        <a class="text-white" href="{{ route('admin.dashboard') }}">
            <i class="ni ni-box-2" style="font-size: 16px;">  &nbsp;{{ trans('app.Home') }}&nbsp;</i>
        </a>
    </li>
    @if(@$breadcrumb)
        @foreach ($breadcrumb as $key=>$value)
            <li class="breadcrumb-item text-sm text-white" style="font-size: 16px!important;"><a href="{{ $value }}">{{ $key }}</a></li>
        @endforeach
    @endif
    <li class="breadcrumb-item text-sm text-white active" aria-current="page" style="font-size: 16px!important;">{{ " ".@$page_title }}</li>
</ol>
