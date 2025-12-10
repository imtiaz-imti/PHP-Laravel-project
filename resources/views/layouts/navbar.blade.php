<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm py-3">
    <div class="container">

        <!-- Logo + App Name -->
        <a class="navbar-brand d-flex align-items-center" href="/">
            <img src="{{ asset('asset/icon-twitter-2898665_1280.png') }}" 
                 alt="logo" style="height: 35px;" class="me-2">
            <span class="fw-bold fs-5">Laravel Project</span>
        </a>

        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Collapsible content -->
        <div class="collapse navbar-collapse" id="navbarContent">

            <!-- Center Search Bar -->
            <form action="{{ route('search_user') }}" method="GET" class="mx-auto d-flex flex-grow-1 my-2 my-lg-0" style="max-width: 500px;">
                <input name="search" class="form-control me-2" type="search" autocomplete="off" placeholder="Search users" aria-label="Search">
                <button class="btn btn-primary" type="submit">Search</button>
            </form>

            <!-- Right Side: Logout -->
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a href="/logout" class="logout btn btn-outline-primary d-flex align-items-center">
                        <img src="{{ asset('asset/logout.png') }}" alt="logo" style="height: 25px;" class="me-2">
                        Log Out
                    </a>
                </li>
            </ul>

        </div>
    </div>
</nav>

<style>
/* Optional: Improve mobile spacing */
@media (max-width: 576px) {
    .navbar-brand span {
        font-size: 14px;
    }

    .navbar-nav .btn {
        font-size: 14px;
        padding: 5px 10px;
    }

    form input.form-control {
        font-size: 14px;
    }

    form button.btn {
        font-size: 14px;
        padding: 5px 10px;
    }
    
    .logout {
       width: 30%; 
    }
}
</style>


