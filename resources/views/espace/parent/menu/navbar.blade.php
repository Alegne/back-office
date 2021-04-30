<nav class="navbar navbar-expand-lg " color-on-scroll="500">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">{{ $title }}</a>
        <button href="" class="navbar-toggler navbar-toggler-right"
                type="button" data-toggle="collapse" aria-controls="navigation-index"
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar burger-lines"></span>
            <span class="navbar-toggler-bar burger-lines"></span>
            <span class="navbar-toggler-bar burger-lines"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navigation">
            <ul class="nav navbar-nav mr-auto"></ul>
            <ul class="navbar-nav ml-auto">
                {{-- <li class="dropdown nav-item">
                    <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                        <i class="nc-icon nc-planet"></i>
                        <span class="notification">5</span>
                        <span class="d-lg-none">Notifications</span>
                    </a>
                    <ul class="dropdown-menu">
                        <a class="dropdown-item" href="#">Notification 1</a>
                        <a class="dropdown-item" href="#">Notification 2</a>
                        <a class="dropdown-item" href="#">Another notification</a>
                    </ul>
                </li> --}}
                {{-- <li class="nav-item">
                    <a class="nav-link" href="{{ route('espace.profils.index') }}">
                        <span class="no-icon">Compte</span>
                    </a>
                </li> --}}
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('espace.logout') }}">
                        <span class="no-icon">Se deconnecter</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
