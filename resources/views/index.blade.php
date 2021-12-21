<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    @include('sections.header')

    <body class="hold-transition sidebar-mini layout-fixed">

        <div class="wrapper" id="app">
            <App
                base-path="{{ route('basepath') }}"
            />
        </div>
        <!-- ./wrapper -->

        @include('sections.dependences')

    </body>

</html>
