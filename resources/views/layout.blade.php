<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">

<style>
    .cover-container {
        background-color: #1a202c;
    }
    h2  {
        color: #fff;
    }
    p {
        color: #cbd5e0;
    }
</style>

<div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
    <div class="mb-auto"></div>

    <main class="px-3">
        <div class="d-block mx-auto mb-4 col-10">
            @yield('content')
        </div>
    </main>

    <div class="mt-auto text-white-50"></div>
</div>

@stack('scripts')
