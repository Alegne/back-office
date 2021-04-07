@props(['route', 'sub', 'icon'])

<li class="nav-item">
    <a  @if($route) href="{{ route($route) }}" @else href="#" @endif
       class="nav-link
        @if($route) {{ currentRouteActive($route) }}@endif
            ">
        <i class="

        @isset($sub) far fa-circle @endisset

        nav-icon

        @isset($icon) fas fa-{{ $icon }} @endisset

        "></i>
        <p>{{ $slot }}</p>
    </a>
</li>
