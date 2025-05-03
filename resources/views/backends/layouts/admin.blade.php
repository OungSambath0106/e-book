<!DOCTYPE html>
<html lang="en">

@include('backends.layouts.head')

<body class="g-sidenav-show bg-gray-100 {{ (config('app.dark-version') == 1 ? 'dark-version' : '') }}">
    <div class="min-height-300 bg-dark position-absolute w-100"></div>

    @include('backends.layouts.sidebar')

    <main class="main-content position-relative border-radius-lg ">
        <!-- Navbar -->
        @include('backends.layouts.navbar')

        <!-- End Navbar -->
        <div class="container-fluid py-4">
            @yield('contents')

            @include('backends.layouts.footer')
        </div>

    </main>

    {{-- @include('backends.layouts.setting_configuration') --}}
    <!--   Core JS Files   -->
    @include('backends.layouts.script')
</body>

</html>
