
@isset($etudiants)
    @if(count($etudiants))
        @foreach($etudiants as $etudiant)
            @include('back.etudiant.filter._card', ['etudiant' => $etudiant])
        @endforeach
    @else
        <p class="text-center text-danger"> AUCUN ETUDIANT</p>
    @endif

@else
    <p class="text-center text-danger"> NO CRITERE</p>
@endisset
