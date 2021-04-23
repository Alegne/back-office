<template>
    <div>

        <div class="row mx-1">
            <div class="card">
                <div class="card-header justify-content-end ml-1">
                    <button class="btn btn-primary" type="button" data-toggle="collapse"
                            data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                        Toggle
                    </button>
                </div>
                <div class="card-body">
                    <div class="collapse" id="collapseExample">
                        <div class="card card-body">
                            <div class="row">
                                <div class="card col-md-2 ml-1">
                                    <div class="card-header">Types</div>
                                    <div class="card-body">
                                        <div class="form-check" >
                                            <input class="form-check-input" type="checkbox">
                                            <label class="form-check-label" >
                                                Ancien
                                            </label>
                                        </div>
                                        <div class="form-check" v-for="">
                                            <input class="form-check-input" type="checkbox">
                                            <label class="form-check-label" >
                                                Actif
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="card col-md-2 ml-1">
                                    <div class="card-header">Niveaux</div>
                                    <div class="card-body">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox">
                                            <label class="form-check-label" >
                                                L1
                                            </label>
                                        </div>
                                        <div class="form-check" >
                                            <input class="form-check-input" type="checkbox">
                                            <label class="form-check-label">
                                                L2
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
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox">
                                            <label class="form-check-label">
                                                SR
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
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox">
                                            <label class="form-check-label">
                                                Licence
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
        </div>

        <div class="row">
            <div class="card col-md-3">
                <img class="card-img-top" src="/default.png" alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                </div>
            </div>
            <div class="card col-md-3">
                <img class="card-img-top" src="/default.png" alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                </div>
            </div>
            <div class="card col-md-3">
                <img class="card-img-top" src="/default.png" alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                </div>
            </div>
            <div class="card col-md-3">
                <img class="card-img-top" src="/default.png" alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
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
                type       : [],
                etudiants  : [],
                loading    : true,
                selected   : {
                    niveaux    : [],
                    parcours   : [],
                    annees     : [],
                    formations : [],
                    type       : []
                }
            }
        },

        mounted() {
            this.loadNiveaux();
            this.loadParcours();
            this.loadAnnees();
            this.loadFormations();
            this.loadTypes();
            this.loadEtudiants();
        },

        watch: {
            selected: {
                handler: function () {
                    this.loadNiveaux();
                    this.loadParcours();
                    this.loadAnnees();
                    this.loadFormations();
                    this.loadTypes();
                    this.loadEtudiants();
                },
                deep: true
            }
        },

        methods: {
            loadNiveaux: function () {

            },
            loadParcours: function () {

            },
            loadAnnees : function () {

            },
            loadFormations : function () {

            },
            loadTypes : function () {

            },
            loadEtudiants : function () {

            }
        }
    }
</script>
