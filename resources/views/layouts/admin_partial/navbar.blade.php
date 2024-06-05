<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                    class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ route('admin.dashboard') }}" class="nav-link">Home</a>
        </li>
        {{-- <li class="nav-item d-none d-sm-inline-block">
            <a href="#" class="nav-link">Contact</a>
        </li> --}}
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Admin Name -->
        <li class="nav-item pr-3">
            </a>

                <form method="POST" id="logout" action="{{route('admin.logout')}}">
                    @csrf
                    <a id="logout" href=""
                        onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        Logout</a>
                </form>

        </li>


    </ul>
</nav>