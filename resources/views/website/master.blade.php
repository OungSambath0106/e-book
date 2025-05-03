<!DOCTYPE html>
<html lang="en">
<head>
    @include('website.layout.head')

</head>
<body>
    <!-- Header -->
    @include('website.layout.navbar')

    <main class="main-content">
        @yield('content')
    </main>

    <!-- Footer -->
    @include('website.layout.footer')

    @include('website.layout.script')
</body>
</html>
