<template>
    <div class="row">

        <div class="col-12">
            <div class="row mx-1">
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
                                <div class="card col-md-2 ml-1">
                                    <div class="card-header">Types</div>
                                    <div class="card-body">
                                        <div class="form-check" >
                                            <input class="form-check-input" type="checkbox">
                                            <label class="form-check-label" >
                                                Ancien
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="card col-md-2 ml-1">
                                    <div class="card-header">Niveaux</div>
                                    <div class="card-body">
                                        <div class="form-check" v-for="(niveau, index) in niveaux">
                                            <input class="form-check-input" type="checkbox" :value="niveau.id"
                                                   :id="'niveau'+index" v-model="selected.niveaux">
                                            <label class="form-check-label" >
                                                {{ niveau.tag }} ({{ niveau.etudiants_count }})
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="card col-md-2 ml-1">
                                    <div class="card-header">Parcours</div>
                                    <div class="card-body">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox">
                                            <label class="form-check-label">
                                                GB
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="card col-md-2 ml-1">
                                    <div class="card-header">Formations</div>
                                    <div class="card-body">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox">
                                            <label class="form-check-label">
                                                Master
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="card col-md-2 ml-1">
                                    <div class="card-header">Annee Univesitaire</div>
                                    <div class="card-body">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox">
                                            <label class="form-check-label">
                                                2020-2021
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox">
                                            <label class="form-check-label">
                                                2019-2020
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mx-1">
                <div class="col-12">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Etudiants</h3>
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
                            <div class="row">

                                <div class="card col-md-2 mx-1">
                                    <img class="card-img-top" src="/default.png" alt="Card image cap">
                                    <div class="card-body">
                                        <h5 class="card-title">Card title</h5>
                                        <p class="card-text">nd make up the bulk of the card's content.</p>
                                    </div>
                                </div>
                                <div class="card col-md-2 mx-1">
                                    <img class="card-img-top" src="/default.png" alt="Card image cap">
                                    <div class="card-body">
                                        <h5 class="card-title">Card title</h5>
                                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                    </div>
                                </div>
                                <div class="card col-md-2 mx-1">
                                    <img class="card-img-top" src="/default.png" alt="Card image cap">
                                    <div class="card-body">
                                        <h5 class="card-title">Card title</h5>
                                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                    </div>
                                </div>
                                <div class="card col-md-2 mx-1">
                                    <img class="card-img-top" src="/default.png" alt="Card image cap">
                                    <div class="card-body">
                                        <h5 class="card-title">Card title</h5>
                                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>


</template>



<script>
    export default {
        data: function () {
            return {
                niveaux    : [],
                parcours   : [],
                annees     : [],
                formations : [],
                status     : [],
                etudiants  : [],
                loading    : true,
                selected   : {
                    niveaux    : [],
                    parcours   : [],
                    annees     : [],
                    formations : [],
                    status     : []
                }
            }
        },

        mounted() {
            this.loadNiveaux();
            this.loadParcours();
            this.loadAnnees();
            this.loadFormations();
            this.loadStatus();
            this.loadEtudiants();
        },

        watch: {
            selected: {
                handler: function () {
                    this.loadNiveaux();
                    this.loadParcours();
                    this.loadAnnees();
                    this.loadFormations();
                    this.loadStatus();
                    this.loadEtudiants();
                },
                deep: true
            }
        },

        methods: {
            loadNiveaux: function () {
                axios.get('/api/niveaux/etudiants', {
                    params: _.omit(this.selected, 'niveaux') // exclure categories
                })
                    .then((response) => {
                        this.niveaux = response.data.data;

                        console.log(this.niveaux)
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            loadParcours: function () {
                axios.get('/api/parcours/etudiants', {
                    params: _.omit(this.selected, 'parcours') // exclure categories
                })
                    .then((response) => {
                        this.parcours = response.data.data;

                        console.log(this.parcours)
                    })
                    .catch(function (error) {
                        console.log(error);
                    });

            },
            loadAnnees : function () {
                axios.get('/api/annee-universitaire/etudiants', {
                    params: _.omit(this.selected, 'annees') // exclure categories
                })
                    .then((response) => {
                        this.annees = response.data.data;

                        console.log(this.annees)
                    })
                    .catch(function (error) {
                        console.log(error);
                    });

            },
            loadFormations : function () {
                axios.get('/api/formations/etudiants/filter', {
                    params: _.omit(this.selected, 'formations') // exclure categories
                })
                    .then((response) => {
                        this.formations = response.data.data;

                        console.log(this.formations)
                    })
                    .catch(function (error) {
                        console.log(error);
                    });

            },
            loadStatus : function () {
                axios.get('/api/etudiants/filter/status', {
                    params: _.omit(this.selected, 'status') // exclure categories
                })
                    .then((response) => {
                        this.status = response.data.data;

                        console.log(this.annees)
                    })
                    .catch(function (error) {
                        console.log(error);
                    });

            },
            loadEtudiants : function () {
                axios.get('/api/etudiants/filter/vue', {
                    params: this.selected
                })
                    .then((response) => {
                        this.etudiants = response.data.data;
                        this.loading = false;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            }
        }
    }
</script>
