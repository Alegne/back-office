<form action="{{ route('etudiant.filter.new.request') }}" method="get" id="form-critere">

    {{--@dd($niveaux, $status)--}}

    <div class="col-12">
        <div class="card card-outline card-info">
            <div class="card-header">
                <h3 class="card-title">Criteres</h3>
                <div class="card-tools pull-right">
                    <button
                            type="button"
                            class="btn btn-tool"
                            data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">

                <div class="row justify-content-center">

                    {{-- Status --}}
                    <div class="card col-md-2 ml-1">
                        <div class="card-header">Status</div>
                        <div class="card-body">
                            @foreach($status as $key => $value)
                                <div class="form-check" >
                                    <input class="form-check-input" name="status[]"
                                           type="checkbox" value="{{ $key }}"
                                    @isset($data['status'])
                                        @foreach($data['status'] as $data_item)
                                            {{ $data_item == $key ? 'checked' : '' }}
                                                @endforeach
                                            @endisset
                                    >
                                    <label class="form-check-label">
                                        {{ $value }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Niveaux --}}
                    <div class="card col-md-2 ml-1">
                        <div class="card-header">Niveaux</div>
                        <div class="card-body">
                            @foreach($niveaux as $niveau)
                                <div class="form-check">
                                    <input class="form-check-input" name="niveaux[]" type="checkbox"
                                           value="L1"
                                    @isset($data['niveaux'])
                                        @foreach($data['niveaux'] as $niveaux)
                                            {{ $niveaux == $niveau ? 'checked' : '' }}
                                                @endforeach
                                            @endisset
                                    >
                                    <label class="form-check-label">{{ $niveau }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Parcours --}}
                    <div class="card col-md-2 ml-1">
                        <div class="card-header">Parcours</div>
                        <div class="card-body">
                            @foreach($parcours as $parcours_item)
                            <div class="form-check">
                                <input class="form-check-input" name="parcours[]" type="checkbox"
                                       value="GB"
                                        @isset($data['parcours'])
                                            @foreach($data['parcours'] as $niveaux)
                                                {{ $niveaux == $parcours_item ? 'checked' : '' }}
                                            @endforeach
                                        @endisset
                                >
                                <label class="form-check-label">{{ $parcours_item }} </label>
                            </div>
                                @endforeach
                        </div>
                    </div>

                    {{-- Formations --}}
                    <div class="card col-md-2 ml-1">
                        <div class="card-header">Formations</div>
                        <div class="card-body">
                            @foreach($formations as $formation)
                                <div class="form-check">
                                    <input class="form-check-input" name="formations[]" type="checkbox"
                                           value="Licence"
                                    @isset($data['formations'])
                                        @foreach($data['formations'] as $niveaux)
                                            {{ $niveaux == $formation ? 'checked' : '' }}
                                                @endforeach
                                            @endisset
                                    >
                                    <label class="form-check-label">{{ $formation }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Annee Univesitaire --}}
                    <div class="card col-md-2 ml-1">
                        <div class="card-header">Annee Univesitaire</div>
                        <div class="card-body">
                            @foreach($annees as $annee)
                                <div class="form-check">
                                    <input class="form-check-input" name="annees[]" type="checkbox"
                                           value="2020-2021"
                                    @isset($data['annees'])
                                        @foreach($data['annees'] as $niveaux)
                                            {{ $niveaux == $annee ? 'checked' : '' }}
                                                @endforeach
                                            @endisset
                                    >
                                    <label class="form-check-label">{{ $annee }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Informations --}}
                    <div class="card col-md-10 ml-1">
                        <div class="card-header">Informations</div>
                        <div class="card-body">
                            <div class="form-group">
                                <input type="text" class="form-control" name="numero"
                                       placeholder="Entrer le Numero d'Etudiant"
                                       value="@isset($data['numero']) {{ $data['numero'] }} @endisset"
                                >
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="nom"
                                       placeholder="Entrer le Nom d'Etudiant"
                                       value="@isset($data['nom']) {{ $data['nom'] }} @endisset"
                                >
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="prenom"
                                       placeholder="Entrer le Prenom d'Etudiant"
                                       value="@isset($data['prenom']) {{ $data['prenom'] }} @endisset"
                                >
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-right">
                <button type="submit" class="btn btn-primary">Rechercher</button>
            </div>
        </div>
    </div>
</form>
