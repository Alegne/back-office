@extends('back.parent.layout')

@section('breadcrumb')

    @include('back.parent.partial.breadcrumb', [
        'parent' => 'Parametres',
        'parent_route' => route('user.index'),
        'child' => 'Comptes',
    ])

@endsection

@section('css')@endsection

@section('main')

    <div class="row">
        <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">

                        @if($user->photo)
                            <img class="profile-user-img img-fluid img-circle"
                                 src="{{ getImageSingle($user->photo, true) }}" alt="User profile picture">
                        @else
                            <img src="{{ asset('/default.png') }}" style="width:100%;">
                        @endif

                    </div>

                    <h3 class="profile-username text-center">{{ $user->identifiant }}</h3>

                    <p class="text-muted text-center">{{ ucfirst($user->role) }}</p>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <form class="form-horizontal">
                        <div class="form-group row">
                            <label for="email" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="email"
                                       placeholder="Email" value="{{ $user->email }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-sm-2 col-form-label">Mot de passe</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" id="password"
                                       placeholder="password" value="{{ $user->email }}">
                            </div>
                        </div>
                    </form>
                </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>


@endsection

@section('js')@endsection
