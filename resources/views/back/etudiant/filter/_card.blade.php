<div class="card etudiant col-md-2 mx-1"
     style="cursor:pointer;"
     id="etudiant{{ $etudiant->id }}"
     data-photo="{{ $etudiant->photo }}"
     data-id="{{ $etudiant->id }}"
     data-route="{{ route('etudiant.show', ['etudiant' => $etudiant->id]) }}">

    @if($etudiant->photo)
        <img class="card-img-top" src="{{ getImageSingle($etudiant->photo, true) }}" alt="Card image cap">
    @else
        <img class="card-img-top" src="/default.png" alt="Card image cap">
    @endif

    <div class="card-body">
        <h5 class="card-title">
            {{ $etudiant->numero }}<br>
            {{ $etudiant->nom }}<br>
            {{ $etudiant->prenom }}<br>
            <span class="btn btn-info">{{ $etudiant->status }}</span><br>
        </h5>
    </div>
</div>
