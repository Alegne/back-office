<form action="{{ route('etudiant.filter.new.request') }}" method="get" id="form-critere">

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
                            <div class="form-check" >
                                <input class="form-check-input" name="status[]"
                                       type="checkbox" value="ancien"
                                       @isset($data['status'])
                                           @foreach($data['status'] as $status)
                                               {{ $status == 'ancien' ? 'checked' : '' }}
                                           @endforeach
                                       @endisset
                                >
                                <label class="form-check-label">
                                    Ancien
                                </label>
                            </div>
                            <div class="form-check" >
                                <input class="form-check-input" name="status[]" type="checkbox"
                                       value="actif"
                                        @isset($data['status'])
                                            @foreach($data['status'] as $status)
                                                {{ $status == 'actif' ? 'checked' : '' }}
                                            @endforeach
                                        @endisset
                                >
                                <label class="form-check-label">
                                    Actif
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- Niveaux --}}
                    <div class="card col-md-2 ml-1">
                        <div class="card-header">Niveaux</div>
                        <div class="card-body">
                            <div class="form-check">
                                <input class="form-check-input" name="niveaux[]" type="checkbox"
                                       value="L1"
                                        @isset($data['niveaux'])
                                            @foreach($data['niveaux'] as $niveaux)
                                                {{ $niveaux == 'L1' ? 'checked' : '' }}
                                            @endforeach
                                        @endisset
                                >
                                <label class="form-check-label">L1</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" name="niveaux[]" type="checkbox"
                                       value="L2"
                                        @isset($data['niveaux'])
                                            @foreach($data['niveaux'] as $niveaux)
                                                {{ $niveaux == 'L2' ? 'checked' : '' }}
                                            @endforeach
                                        @endisset
                                >
                                <label class="form-check-label">L2</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" name="niveaux[]" type="checkbox"
                                       value="L3"
                                        @isset($data['niveaux'])
                                            @foreach($data['niveaux'] as $niveaux)
                                                {{ $niveaux == 'L3' ? 'checked' : '' }}
                                            @endforeach
                                        @endisset
                                >
                                <label class="form-check-label">L3</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" name="niveaux[]" type="checkbox"
                                       value="M1"
                                        @isset($data['niveaux'])
                                            @foreach($data['niveaux'] as $niveaux)
                                                {{ $niveaux == 'M1' ? 'checked' : '' }}
                                            @endforeach
                                        @endisset
                                >
                                <label class="form-check-label">M1</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" name="niveaux[]" type="checkbox"
                                       value="M2"
                                        @isset($data['niveaux'])
                                            @foreach($data['niveaux'] as $niveaux)
                                                {{ $niveaux == 'M2' ? 'checked' : '' }}
                                            @endforeach
                                        @endisset
                                >
                                <label class="form-check-label">M2</label>
                            </div>
                        </div>
                    </div>

                    {{-- Parcours --}}
                    <div class="card col-md-2 ml-1">
                        <div class="card-header">Parcours</div>
                        <div class="card-body">
                            <div class="form-check">
                                <input class="form-check-input" name="parcours[]" type="checkbox"
                                       value="GB"
                                        @isset($data['parcours'])
                                            @foreach($data['parcours'] as $niveaux)
                                                {{ $niveaux == 'GB' ? 'checked' : '' }}
                                            @endforeach
                                        @endisset
                                >
                                <label class="form-check-label"> GB </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" name="parcours[]" type="checkbox"
                                       value="SR"
                                        @isset($data['parcours'])
                                            @foreach($data['parcours'] as $niveaux)
                                                {{ $niveaux == 'SR' ? 'checked' : '' }}
                                            @endforeach
                                        @endisset
                                >
                                <label class="form-check-label"> SR </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" name="parcours[]" type="checkbox"
                                       value="IG"
                                        @isset($data['parcours'])
                                            @foreach($data['parcours'] as $niveaux)
                                                {{ $niveaux == 'IG' ? 'checked' : '' }}
                                            @endforeach
                                        @endisset
                                >
                                <label class="form-check-label">
                                    IG
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- Formations --}}
                    <div class="card col-md-2 ml-1">
                        <div class="card-header">Formations</div>
                        <div class="card-body">
                            <div class="form-check">
                                <input class="form-check-input" name="formations[]" type="checkbox"
                                       value="Licence"
                                        @isset($data['formations'])
                                            @foreach($data['formations'] as $niveaux)
                                                {{ $niveaux == 'Licence' ? 'checked' : '' }}
                                            @endforeach
                                        @endisset
                                >
                                <label class="form-check-label">Licence</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" name="formations[]" type="checkbox"
                                       value="Master"
                                        @isset($data['formations'])
                                            @foreach($data['formations'] as $niveaux)
                                                {{ $niveaux == 'Master' ? 'checked' : '' }}
                                            @endforeach
                                        @endisset
                                >
                                <label class="form-check-label">Master</label>
                            </div>
                        </div>
                    </div>

                    {{-- Annee Univesitaire --}}
                    <div class="card col-md-2 ml-1">
                        <div class="card-header">Annee Univesitaire</div>
                        <div class="card-body">
                            <div class="form-check">
                                <input class="form-check-input" name="annees[]" type="checkbox"
                                       value="2020-2021"
                                        @isset($data['annees'])
                                            @foreach($data['annees'] as $niveaux)
                                                {{ $niveaux == '2020-2021' ? 'checked' : '' }}
                                            @endforeach
                                        @endisset
                                >
                                <label class="form-check-label">
                                    2020-2021
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" name="annees[]" type="checkbox"
                                       value="2019-2020"
                                        @isset($data['annees'])
                                            @foreach($data['annees'] as $niveaux)
                                                {{ $niveaux == '2019-2020' ? 'checked' : '' }}
                                            @endforeach
                                        @endisset
                                >
                                <label class="form-check-label">2019-2020</label>
                            </div>
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
