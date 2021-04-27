@extends('back.parent.layout')

@section('css')
@endsection

@section('main')


<div class="">

    <!-- Card Statique -->
    <div class="row">

      <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
          <span class="info-box-icon bg-info elevation-1"><i class="fas fa-user"></i></span>

          <div class="info-box-content">
            <span class="info-box-text">Comptes</span>
            <span class="info-box-number" id="compte">
              {{ $users }}
            </span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
      <!-- /.col -->

      <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
          <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-chalkboard-teacher"></i></span>

          <div class="info-box-content">
            <span class="info-box-text">Enseignants</span>
            <span class="info-box-number" id="enseignant">{{ $enseignants }}</span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
      <!-- /.col -->

      <!-- fix for small devices only -->
      <div class="clearfix hidden-md-up"></div>

      <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
          <span class="info-box-icon bg-success elevation-1"><i class="fas fa-users"></i></span>

          <div class="info-box-content">
            <span class="info-box-text">Etudiants Anciens</span>
            <span class="info-box-number" id="ancien">{{ $etudiants_ancien }}</span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
      <!-- /.col -->
      <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
          <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

          <div class="info-box-content">
            <span class="info-box-text">Etudiants actifs</span>
            <span class="info-box-number" id="actif">{{ $etudiants_actif }}</span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Nombre d'etudiant par niveau -->
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h5 class="card-title">Nombre d'etudiant par niveau</h5>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
              <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-footer">
            <div class="row justify-content-center">
                @foreach($niveaux as $total => $tag)
              <div class="col-sm-2 col-4">
                <div class="description-block border-right">
                  <h5 class="description-header">{{ $total }}</h5>
                  <span class="description-text">{{ $tag }}</span>
                </div>
                <!-- /.description-block -->
              </div>
              <!-- /.col -->
                    @endforeach

            </div>
            <!-- /.row -->
          </div>
          <!-- /.card-footer -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Nombre d'etudiant par parcours -->
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h5 class="card-title">Nombre d'etudiant par parcours</h5>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
              <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-footer">
            <div class="row justify-content-center">
                @foreach($parcours as $total => $tag)
              <div class="col-sm-4 col-4">
                <div class="description-block border-right">
                  <h5 class="description-header">{{ $total }}</h5>
                  <span class="description-text">{{ $tag }}</span>
                </div>
                <!-- /.description-block -->
              </div>
              <!-- /.col -->
                @endforeach

            </div>
            <!-- /.row -->
          </div>
          <!-- /.card-footer -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Graphe nombre d'etudiant par annee 5derniers -->
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h5 class="card-title">Graphe nombre d'etudiant par annee 4 derniers</h5>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
              <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">
              <div class="col-md-8">
                <p class="text-center">
                  <strong>{{ formatDate(\Carbon\Carbon::now()) }}</strong>
                </p>

                <div class="chart"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                  <!-- Sales Chart Canvas -->
                  <canvas id="salesChart" height="180" style="height: 180px; display: block; width: 680px;" width="680" class="chartjs-render-monitor"></canvas>
                </div>
                <!-- /.chart-responsive -->
              </div>
              <!-- /.col -->
              <div class="col-md-4">
                <p class="text-center">
                  <strong>Nombre d'etudiant</strong>
                </p>

                  @foreach($annees as $total => $libelle)
                <div class="progress-group">
                    {{ $total }}
                  <span class="float-right"><b>{{ $libelle }}</b></span>
                  <!--
                  <div class="progress progress-sm">
                    <div class="progress-bar bg-primary" style="width: 80%"></div>
                  </div>
                  -->
                </div>
                <!-- /.progress-group -->
                  @endforeach

              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
          </div>
          <!-- ./card-body -->
         {{-- <div class="card-footer">
            <div class="row">
              <div class="col-sm-3 col-6">
                <div class="description-block border-right">
                  <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 17%</span>
                  <h5 class="description-header">$35,210.43</h5>
                  <span class="description-text">Annee 2018</span>
                </div>
                <!-- /.description-block -->
              </div>
              <!-- /.col -->
              <div class="col-sm-3 col-6">
                <div class="description-block border-right">
                  <span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> 0%</span>
                  <h5 class="description-header">$10,390.90</h5>
                  <span class="description-text">Annee 2019</span>
                </div>
                <!-- /.description-block -->
              </div>
              <!-- /.col -->
              <div class="col-sm-3 col-6">
                <div class="description-block border-right">
                  <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 20%</span>
                  <h5 class="description-header">$24,813.53</h5>
                  <span class="description-text">Annee 2020</span>
                </div>
                <!-- /.description-block -->
              </div>
              <!-- /.col -->
              <div class="col-sm-3 col-6">
                <div class="description-block">
                  <span class="description-percentage text-danger"><i class="fas fa-caret-down"></i> 18%</span>
                  <h5 class="description-header">1200</h5>
                  <span class="description-text">Annee 2021</span>
                </div>
                <!-- /.description-block -->
              </div>
            </div>
            <!-- /.row -->
          </div>--}}
          <!-- /.card-footer -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
  </div>


@endsection

@section('js')
@endsection
