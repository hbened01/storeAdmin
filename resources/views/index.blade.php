<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    @include('sections.header')

    <body class="hold-transition sidebar-mini layout-fixed">

        <div class="wrapper" id="app">
            @if (Auth::check())
                <App
                    base-path="{{ route('basepath') }}"
                />

            @else
                <Auth
                    base-path="{{ route('basepath') }}"
                />
            @endif
        </div>
        <!-- ./wrapper -->

        @include('sections.dependences')

    </body>

</html>
