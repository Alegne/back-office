<ul class="nav">
    <li>
        <a class="nav-link" href="{{ route('espace.index') }}">
            <i class="fa fa-home" aria-hidden="true"></i>
            <p>Accueil</p>
        </a>
    </li>
    <li>
        <a class="nav-link" href="{{ route('espace.annonces.index') }}">
            <i class="nc-icon nc-bell-55"></i>
            <p>Annonces</p>
        </a>
    </li>

{{--    @if($type == 'etudiant')--}}
{{--        @if($data->status == 'actif')--}}
            <li>
                <a class="nav-link" href="{{ route('espace.emploi_temps.index') }}">
                    <i class="nc-icon nc-notes"></i>
                    <p>Emploi du temps</p>
                </a>
            </li>
            <li>
                <a class="nav-link" href="{{ route('espace.espace_numerique.index') }}">
                    <i class="nc-icon nc-paper-2"></i>
                    <p>Espace Numerique</p>
                </a>
            </li>
        {{--@endif--}}
    {{--@endif--}}

    <li>
        <a class="nav-link" href="{{ route('espace.profils.index') }}">
            <i class="nc-icon nc-circle-09"></i>
            <p>Profil</p>
        </a>
    </li>
</ul>
