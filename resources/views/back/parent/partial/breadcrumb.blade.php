<div class="col-sm-6">
    @isset($parent)
        <h1 class="m-0">{{ $parent }}</h1>
    @endisset
</div><!-- /.col -->
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">

            @isset($parent_route)
            <a href="{{ $parent_route }}">

                @isset($parent)
                    {{ $parent }}
                @endisset
            </a>
           @endisset
        </li>
        <li class="breadcrumb-item active">
            @isset($child)
                {{ $child }}
            @endisset
        </li>
    </ol>
</div><!-- /.col -->
