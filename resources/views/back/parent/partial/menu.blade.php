{{-- Parcourir menu config --}}
@foreach(config('menu') as $name => $elements)

    {{-- Si element doit afficher au role redacteur --}}
    {{--@if($elements['role'] === 'redacteur' || auth()->user()->isAdmin())--}}

    {{-- Si element possede un children --}}
    @isset($elements['children'])

        {{-- MenuOpen return 'menu-open' --}}
        <li class="nav-item has-treeview {{ menuOpen($elements['children']) }}">

            {{-- currentChildActive return 'active'--}}
            <a href="#" class="nav-link {{ currentChildActive($elements['children']) }}">
                <i class="nav-icon fas fa-{{ $elements['icon'] }}"></i>
                <p>
                    {{--@lang($name)--}} {{ $name  }}
                    <i class="right fas fa-angle-left"></i>
                    {{-- <i class="fas fa-angle-left right"></i>--}}
                </p>
            </a>
            <ul class="nav nav-treeview">

                {{-- Parcourir children --}}
                @foreach($elements['children'] as $child)

                    {{-- Si element doit afficher au role redac --}}
                    {{--                        @if(($child['role'] === 'redac' || auth()->user()->isAdmin()) && $child['name'] !== 'fake')--}}

                    {{-- Appel  composant menu-item.blade.php --}}
                    <x-back.menu-item
                            :route="$child['route']"
                            :sub=true>
                        {{--@lang($child['name'])--}} {{ $child['name'] }}
                    </x-back.menu-item>
                    {{--@endif--}}
                @endforeach
            </ul>
        </li>

        {{-- Si element ne possede pas un children --}}
    @else

        {{-- Appel  composant menu-item.blade.php --}}
        <x-back.menu-item
                :route="$elements['route']"
                :icon="$elements['icon']">
            {{--@lang($name)--}} {{ $name  }}
        </x-back.menu-item>
    @endisset

    {{-- Si element doit afficher au role annonceur --}}
    {{--@elseif ($elements['role'] === 'annonceur' || auth()->user()->isAdmin())--}}
    {{-- Si element possede un children --}}
    @isset($elements['children'])

        {{-- MenuOpen return 'menu-open' --}}
        <li class="nav-item has-treeview {{ menuOpen($elements['children']) }}">

            {{-- currentChildActive return 'active'--}}
            <a href="#" class="nav-link {{ currentChildActive($elements['children']) }}">
                <i class="nav-icon fas fa-{{ $elements['icon'] }}"></i>
                <p>
                    {{--@lang($name)--}} {{ $name  }}
                    <i class="right fas fa-angle-left"></i>
                    {{-- <i class="fas fa-angle-left right"></i>--}}
                </p>
            </a>
            <ul class="nav nav-treeview">

                {{-- Parcourir children --}}
                @foreach($elements['children'] as $child)

                    {{-- Si element doit afficher au role redac --}}
                    {{--@if(($child['role'] === 'redac' || auth()->user()->isAdmin()) && $child['name'] !== 'fake')--}}

                    {{-- Appel  composant menu-item.blade.php --}}
                    <x-back.menu-item
                            :route="$child['route']"
                            :sub=true>
                        {{--@lang($child['name'])--}} {{ $child['name'] }}
                    </x-back.menu-item>
                    {{--@endif--}}
                @endforeach
            </ul>
        </li>

        {{-- Si element ne possede pas un children --}}
    @else

        {{-- Appel  composant menu-item.blade.php --}}
        <x-back.menu-item
                :route="$elements['route']"
                :icon="$elements['icon']">
            {{--@lang($name)--}} {{ $name  }}
        </x-back.menu-item>
    @endisset

    {{-- Si element doit afficher au role administratif --}}
    {{--@elseif ($elements['role'] === 'administratif' || auth()->user()->isAdmin())--}}
    {{-- Si element possede un children --}}
    @isset($elements['children'])

        {{-- MenuOpen return 'menu-open' --}}
        <li class="nav-item has-treeview {{ menuOpen($elements['children']) }}">

            {{-- currentChildActive return 'active'--}}
            <a href="#" class="nav-link {{ currentChildActive($elements['children']) }}">
                <i class="nav-icon fas fa-{{ $elements['icon'] }}"></i>
                <p>
                    {{--@lang($name)--}} {{ $name  }}
                    <i class="right fas fa-angle-left"></i>
                    {{-- <i class="fas fa-angle-left right"></i>--}}
                </p>
            </a>
            <ul class="nav nav-treeview">

                {{-- Parcourir children --}}
                @foreach($elements['children'] as $child)

                    {{-- Si element doit afficher au role redac --}}
                    {{--                        @if(($child['role'] === 'redac' || auth()->user()->isAdmin()) && $child['name'] !== 'fake')--}}

                    {{-- Appel  composant menu-item.blade.php --}}
                    <x-back.menu-item
                            :route="$child['route']"
                            :sub=true>
                        {{--@lang($child['name'])--}} {{ $child['name'] }}
                    </x-back.menu-item>
                    {{--@endif--}}
                @endforeach
            </ul>
        </li>

        {{-- Si element ne possede pas un children --}}
    @else

        {{-- Appel  composant menu-item.blade.php --}}
        <x-back.menu-item
                :route="$elements['route']"
                :icon="$elements['icon']">
            {{--@lang($name)--}} {{ $name  }}
        </x-back.menu-item>
    @endisset
    {{--@endif--}}
@endforeach
