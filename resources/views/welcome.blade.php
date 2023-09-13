<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Sehrish Agro</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

    <!-- PWA  -->
    <meta name="theme-color" content="#6777ef"/>
    <link rel="apple-touch-icon" href="{{ asset('logo.png') }}">
    <link rel="manifest" href="{{ asset('/manifest.json') }}">
</head>

<body>
<div class="container">
    <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
        <div class="col-md-3 mb-2 mb-md-0">
            <a href="/" class="d-inline-flex link-body-emphasis text-decoration-none">
                Sehrish Agro
            </a>
        </div>

        <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
            <li><a href="#" class="nav-link px-2 link-secondary">Home</a></li>
            {{--                <li><a href="#" class="nav-link px-2">Features</a></li>--}}
            {{--                <li><a href="#" class="nav-link px-2">Pricing</a></li>--}}
            {{--                <li><a href="#" class="nav-link px-2">FAQs</a></li>--}}
            {{--                <li><a href="#" class="nav-link px-2">About</a></li>--}}
        </ul>

        <div class="col-md-3 text-end">
            @if (Route::has('admin.login'))
                @auth
                    <a href="{{ route('admin.dashboard') }}"  class="btn btn-outline-primary me-2">Dashboard</a>
                @else
                    <a href="{{ route('admin.login') }}"  class="btn btn-outline-primary me-2">Login</a>
                    @if (Route::has('admin.register'))
                        <a href="{{ route('admin.register') }}" class="btn btn-primary">Sign-up</a>
                    @endif
                @endauth
            @endif
        </div>
    </header>
</div>
<main>
    <section class="container my-5 py-5 text-center">
        <h1>Welcome to Sehrish Agro</h1>
        <!-- Add your content here -->
        <h2 class="text-success">
            <a href="https://soft-itbd.com" target="_blank" class="text-decoration-none text-success">
                Being developed by Soft-ITBD - Smart IT Solutions
            </a>
        </h2>
        <p> Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})</p>
    </section>
</main>
<div class="container">
    <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
        <div class="col-md-4 d-flex align-items-center">
            <a href="/" class="mb-3 me-2 mb-md-0 text-body-secondary text-decoration-none lh-1">
                <svg class="bi" width="30" height="24"><use xlink:href="#bootstrap"/></svg>
            </a>
            <span class="mb-3 mb-md-0 text-body-secondary">&copy; 2023 Sehrish Agro. All rights reserved.</span>
        </div>

        <ul class="nav col-md-4 justify-content-end list-unstyled d-flex">
            <li class="ms-3"><a class="text-body-secondary" href="#"><svg class="bi" width="24" height="24"><use xlink:href="#twitter"/></svg></a></li>
            <li class="ms-3"><a class="text-body-secondary" href="#"><svg class="bi" width="24" height="24"><use xlink:href="#instagram"/></svg></a></li>
            <li class="ms-3"><a class="text-body-secondary" href="#"><svg class="bi" width="24" height="24"><use xlink:href="#facebook"/></svg></a></li>
        </ul>
    </footer>
</div>


<!-- Bootstrap JS and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://unpkg.com/@popperjs/core@2"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
<script src="{{ asset('/sw.js') }}"></script>
<script>
    if ("serviceWorker" in navigator) {
        // Register a service worker hosted at the root of the
        // site using the default scope.
        navigator.serviceWorker.register("/sw.js").then(
            (registration) => {
                console.log("Service worker registration succeeded:", registration);
            },
            (error) => {
                console.error(`Service worker registration failed: ${error}`);
            },
        );
    } else {
        console.error("Service workers are not supported.");
    }
</script>
</body>
</html>
