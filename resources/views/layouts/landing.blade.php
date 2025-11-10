<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.partials.head')
</head>
<body class="bg-gray-100 text-gray-800 font-sans">

    <!-- Navigation Bar -->
    @include('layouts.partials.navbar')

    <!-- Content -->
    @yield('content')

    <!-- Footer -->
    @include('layouts.partials.footer')

    @include('layouts.partials.scripts')

</body>
</html>
