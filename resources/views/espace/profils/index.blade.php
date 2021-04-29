@extends('espace.parent.layout')

@section('css')@endsection

@section('content')

    <form action="{{ route('espace.profils.update', ['id' => $data->id, 'type' => $type]) }}"
          method="post"
          enctype="multipart/form-data"
    >
        @csrf
        @method('PUT')



    @if(session('ok'))

        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {!! session('ok') !!}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <x-back.validation-errors :errors="$errors" />

    <div class="row">

        <input type="hidden" name="type" value="{{ $type }}">

        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Editer Profil</h4>
                </div>
                <div class="card-body">

                    {{-- Etudiant --}}
                    @if($type == 'etudiant')
                    <div class="row">
                        <div class="col-md-6 pr-1">
                            <div class="form-group">
                                <label>Numero d'etudiant</label>
                                <input type="text" class="form-control"
                                       disabled=""
                                       name="numero"
                                       value="ET0001">
                            </div>
                        </div>
                        <div class="col-md-6 px-1">
                            <div class="form-group">
                                <label>Status</label>
                                <input type="text" class="form-control" disabled=""
                                       name="status"
                                       value="Actif">
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="row">
                        <div class="col-md-6 pr-1">
                            <div class="form-group">
                                <label>Nom</label>
                                <input type="text" class="form-control {{ $errors->has('nom') ? ' is-invalid' : '' }}"
                                       name="nom"
                                       value="{{ old('nom', $data->nom) }}" required>

                                @if ($errors->has('nom'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('nom') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6 pl-1">
                            <div class="form-group">
                                <label>Prenom</label>
                                <input type="text" class="form-control {{ $errors->has('prenom') ? ' is-invalid' : '' }}"
                                       name="prenom"
                                       value="{{ old('prenom', $data->prenom) }}" required>

                                @if ($errors->has('prenom'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('prenom') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Enseignant --}}
                    @if($type == 'enseignant')
                        <div class="row">
                            <div class="col-md-6 pr-1">
                                <div class="form-group">
                                    <label>Titre</label>
                                    <input type="text" class="form-control {{ $errors->has('titre') ? ' is-invalid' : '' }}"
                                           name="titre"
                                           value="{{ old('titre', $data->titre) }}" required>

                                    @if ($errors->has('titre'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('titre') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6 pl-1">
                                <div class="form-group">
                                    <label>Grade</label>
                                    <input type="text" class="form-control {{ $errors->has('grade') ? ' is-invalid' : '' }}"
                                           name="grade"
                                           value="{{ old('grade', $data->nom) }}" required>

                                    @if ($errors->has('grade'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('grade') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif


                    <div class="row">
                        <div class="@if($type == 'enseignant') col-md-4 @else col-md-6 @endif">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                       name="email"
                                       value="{{ old('email', $data->email) }}" required>

                                @if ($errors->has('email'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('email') }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Enseignant --}}
                        @if($type == 'enseignant')
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Identifiant</label>
                                    <input type="text" class="form-control {{ $errors->has('identifiant') ? ' is-invalid' : '' }}"
                                           name="identifiant"
                                           value="{{ old('identifiant', $data->identifiant) }}" required>

                                    @if ($errors->has('identifiant'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('identifiant') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Mot de passe</label>
                                    <input type="password" class="form-control {{ $errors->has('mot_de_passe') ? ' is-invalid' : '' }}"
                                           name="mot_de_passe"
                                           value="{{ old('mot_de_passe', $data->mot_de_passe) }}" required>

                                    @if ($errors->has('mot_de_passe'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('mot_de_passe') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif


                        @if($type == 'etudiant')
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Mot de passe</label>
                                <input type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}"
                                       name="password"
                                       value="{{ old('password', $data->password) }}" required>

                                @if ($errors->has('password'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('password') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>

                    <div class="row">
                        <div class="col-md-6 pr-1">
                            <div class="form-group">
                                <label>Adresse</label>
                                <input type="text" class="form-control {{ $errors->has('adresse') ? ' is-invalid' : '' }}"
                                       name="adresse"
                                       value="{{ old('adresse', $data->adresse) }}" required>

                                @if ($errors->has('adresse'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('adresse') }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Etudiant --}}
                        @if($type == 'etudiant')
                        <div class="col-md-6 px-1">
                            <div class="form-group">
                                <label>CIN</label>
                                <input type="text" class="form-control {{ $errors->has('cin') ? ' is-invalid' : '' }}"
                                       name="cin"
                                       value="{{ old('cin', $data->cin) }}" required>

                                @if ($errors->has('cin'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('cin') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        @endif

                        {{-- Enseignant --}}
                        @if($type == 'enseignant')
                        <div class="col-md-6 pl-1">
                            <div class="form-group">
                                <label>Telephone</label>
                                <input type="text" class="form-control {{ $errors->has('telephone') ? ' is-invalid' : '' }}"
                                       name="telephone"
                                       value="{{ old('telephone', $data->telephone) }}" required>

                                @if ($errors->has('telephone'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('telephone') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>

                    {{-- Etudiant --}}
                    @if($type == 'etudiant')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Date de Naissance</label>
                                <input type="date" id="date_naissance"
                                       class="form-control {{ $errors->has('date_naissance') ? ' is-invalid' : '' }}"
                                       name="date_naissance"
                                       value="{{ old('date_naissance', $data->date_naissance) }}">

                                <input type="hidden" id="date_naissance_clone"
                                       value="{{ old('date_naissance', $data->date_naissance) }}">

                                @if ($errors->has('date_naissance'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('date_naissance') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Lieu de Naissance</label>
                                <input type="text" class="form-control {{ $errors->has('lieu_naissance') ? ' is-invalid' : '' }}"
                                       name="lieu_naissance"
                                       value="{{ old('lieu_naissance', $data->lieu_naissance) }}" required>

                                @if ($errors->has('lieu_naissance'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('lieu_naissance') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif


                    <button type="submit" class="btn btn-info btn-fill pull-right">Mettre à jour</button>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-user">
                <div class="card-image">
                    <img src="/bg-eni.jpg" alt="back">
                </div>
                <div class="card-body">
                    <div class="author">
                        <label for="input-photo" style="cursor: pointer;">
                            @isset($data->photo)
                                <img  id="previewImg" class="avatar border-gray" src="{{ getImageSingle($data->photo, true) }}" alt="back"
                                     style="width: 150px !important; height: 150px !important;">
                            @else
                                <img id="previewImg" class="avatar border-gray" src="/logo.png" alt="profile">
                            @endisset

                            <h5 class="title">{{ $data->nom }} {{ $data->prenom }} </h5>
                        </label>

                        {{--Etudiant--}}
                        @if($type == 'etudiant')
                        <p class="description text-center">
                            <strong >{{ $data->numero }}</strong>
                        </p>
                       @endif
                    </div>

                    {{--Etudiant--}}
                    @if($type == 'etudiant')
                    <p class="description text-center">
                        <table>
                            <tr>
                                <td>Niveau</td>
                                <td class="px-3">{{ $data->niveau[0]->tag }}</td>
                            </tr>
                            <tr>
                                <td>Parcours</td>
                                <td class="px-3">{{ $data->parcours->tag }}</td>
                            </tr>
                            <tr>
                                <td>Anne Univesitaire</td>
                                <td class="px-3">{{ $data->annee[0]->tag }}</td>
                            </tr>
                        </table>
                    </p>
                    @endif
                </div>

                <input type="file" class="d-none" name="photo" id="input-photo" value="">

                <hr>
            </div>
        </div>

    </div>
    </form>


@endsection

@section('script')


    <script type="text/javascript" src="/admin/plugins/moment/moment.min.js"></script>

    <script type="text/javascript">
        $(function () {

            $('form').on('change', '#input-photo', e => {
                // $(e.currentTarget).next('.custom-file-label').text(e.target.files[0].name);

                console.log('change input-photo')

                previewFile(e.currentTarget)
            });

            // console.log('Update', $('#date_naissance_clone').val())

            if ($('#date_naissance_clone').val())
            {
                let data_input = $('#date_naissance_clone').val() // Oct 23

                let dateObject = new Date(data_input)

                let dateString = moment(dateObject).format('YYYY-MM-DD');
                console.log('Moment.js', dateString) // Output: 2020-07-21

                $('#date_naissance').val(dateString)
            }
        })

        function previewFile(input){
            let file = $(input).get(0).files[0]

            if(file){
                let reader = new FileReader()

                reader.onload = function(){
                    $('#previewImg').attr("src", reader.result)

                    $('#previewImg').css("height", "150px")

                    $('#previewImg').css("height", "150px")

                    // $('#btn-delete-image').removeClass('d-none')

                    // console.log($("#previewImg").attr("src"))
                }

                reader.readAsDataURL(file)
            }
        }
    </script>

@endsection
