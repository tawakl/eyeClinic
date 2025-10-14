<li class="nav-item dropdown pe-2 d-flex align-items-center">
    <a href="javascript:;" class="nav-link text-white p-0" id="dropdownMenuButton" data-bs-toggle="dropdown"
       aria-expanded="false">
        @if(LaravelLocalization::getCurrentLocale() === 'de')
            <img width="30" src="/assets/img/ar-flag.png"/>
        @else
            <img width="30" src="/assets/img/en-flag.png"/>
        @endif
    </a>
    <ul class="dropdown-menu @if(LaravelLocalization::getCurrentLocale() === 'ar') dropdown-menu-start @else dropdown-menu-end @endif px-2 me-sm-n4"
        aria-labelledby="dropdownMenuButton">
        @foreach(languages() as $key => $lang)
            <li>
                <a href="{{ urlLang(url()->full(), lang(), $key) }}" class="nav-link">
                    @if($key === 'ar')
                        <img width="30" src="/assets/img/ar-flag.png" class="flag"/>
                    @else
                        <img width="30" src="/assets/img/en-flag.png"/>
                    @endif

                    <span class="text-xs text-center dropdown-text-color">{{ trans('app.' . $key) }}</span>

                </a>
            </li>
        @endforeach
    </ul>
</li>
