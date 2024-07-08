<nav class="sb-topnav navbar navbar-expand navbar-pink bg-pink">
    <!-- Navbar Brand-->
    <a class="navbar-brand" href="{{ url('/') }}">
        <img src="https://placeholder.pics/svg/150x50/888888/EEE/Logo" alt="..." height="36">{{ config('app.name', 'Laravel') }}
    </a>
    {{-- <a class="navbar-brand ps-3" href="index.html">Start Bootstrap</a> --}}
    <!-- Sidebar Toggle-->
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
    <!-- Navbar Search-->
    <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
        <div class="input-group">
            <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
            <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
        </div>
    </form>
    <!-- Navbar-->
    
</nav>