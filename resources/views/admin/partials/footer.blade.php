<div class="card">
    <div class="container-fluid">
        @if(LaravelLocalization::getCurrentLocale() === 'en')

            made with <i class="text-danger fa fa-heart"></i> by
            <a href="" class="font-weight-bold" target="_blank">{{__('app.app name') }}</a>
            ©
            <script>
                document.write(new Date().getFullYear())
            </script>
            .
        @else

            تم التطوير بواسطه
            <a href="" class="font-weight-bold" target="_blank">{{__('app.app name') }}</a>
            ©
            <script>
                document.write(new Date().getFullYear())
            </script>
            .
        @endif
    </div>
</div>
