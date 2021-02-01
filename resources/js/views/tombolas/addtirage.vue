<template>
    <div class="modal fade" id="addTirage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Effectuer Tirage</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form class="form-horizontal" @submit.prevent @keydown="tirageForm.errors.clear()">
                        <div class="card-body">

                            <div class="form-group row">
                                <label for="titre" class="col-sm-2 col-form-label text-sm">Titre</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="titre" name="titre" required autocomplete="titre" autofocus placeholder="Titre" v-model="tirageForm.titre">
                                    <span class="invalid-feedback d-block" role="alert" v-if="tirageForm.errors.has('titre')" v-text="tirageForm.errors.get('titre')"></span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="titre" class="col-sm-2 col-form-label text-sm">Nombre à Tirer</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" id="nombre_a_tirer" name="nombre_a_tirer" required autocomplete="nombre_a_tirer" autofocus placeholder="Nombre a Tirer" v-model="tirageForm.nombre_a_tirer">
                                    <span class="invalid-feedback d-block" role="alert" v-if="tirageForm.errors.has('nombre_a_tirer')" v-text="tirageForm.errors.get('nombre_a_tirer')"></span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="description" class="col-sm-2 col-form-label text-sm">Description</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="description" name="description" required autocomplete="description" autofocus placeholder="Description" v-model="tirageForm.description">
                                    <span class="invalid-feedback d-block" role="alert" v-if="tirageForm.errors.has('description')" v-text="tirageForm.errors.get('description')"></span>
                                </div>
                            </div>

                        </div>
                    </form>

                    <div class="overlay-wrapper" v-if="loading">
                        <div class="overlay"><i class="fas fa-3x fa-sync-alt fa-spin"></i><div class="text-bold pt-2">Traitement En Cours...</div></div>
                    </div>

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Fermer</button>
                    <button type="button" class="btn orange" @click="createTirage()" :disabled="!isValidCreateForm">Lancer Le Tirage</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</template>

<script>
    import VueNumber from "vue-number-animation";
    class Tirage {
        constructor(tirage, tombola, urnes) {
            this.titre = tirage.titre || ''
            this.nombre_a_tirer = tirage.nombre_a_tirer || 1
            this.description = tirage.description || ''
            this.urnes = tirage.urnes || urnes
            this.tombola_id = tirage.tombola_id || tombola.id
        }
    }
    export default {
        name: "addtirage",
        props: {
        },
        components: {
            VueNumber
        },
        mounted() {
            this.$parent.$on('add_new_tirage', ({ tombola, urnes }) => {
                this.tombola = tombola
                this.editing = false
                this.tirage = new Tirage({}, tombola, urnes)
                this.tirageForm = new Form(this.tirage)
                $('#addTirage').modal()
            })
        },
        created() {
        },
        data() {
            return {
                tirage: {},
                tirageForm: new Form(new Tirage({}, {}, [])),
                tombola: null,
                editing: false,
                loading: false,
                numberFrom: 0,
                numberTo: 65300354,
                duration: 5,
                scaleClass: false,
            }
        },
        methods: {
            createTirage() {
                this.loading = true
                this.tirageForm
                    .post('/tirages')
                    .then(newtirage => {
                        this.loading = false
                        this.$parent.$emit('new_tirage_added', newtirage)
                        $('#addTirage').modal('hide')
                    }).catch(error => {
                    this.loading = false
                });
            },
            theFormat(number) {
                return number.toFixed(0);
            },
            completed() {
                console.log("Animation ends!");
                this.scaleClass = true;
            },
            playAnimation() {
                console.log("Animation starts!");
                this.scaleClass = false;
                this.$refs.number2.play();
            },
            startmany() {

            }
        },
        computed: {
            isValidCreateForm() {
                return !this.loading
            }
        }
    }
</script>

<style scoped>
    #app {
        font-family: "Avenir", Helvetica, Arial, sans-serif;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        text-align: center;
        color: #2c3e50;
        margin-top: 60px;
    }
    .bold {
        font-weight: bold;
        font-size: 25px;
    }
    .transition {
        transition: all 0.3s ease-in;
    }
    label {
        width: 100px;
        display: inline-block;
    }
    .scaleBig {
        font-size: 35px;
    }
    #wrapper {
        width: 150px;
        display: inline-block;
        padding: 20px 0;
        border-radius: 15px;
        box-shadow: 0 3px 8px 0 rgba(0, 0, 0, 0.18);
    }
    input {
        display: inline-block;
        margin: 10px;
        padding: 10px;
    }
    .btn {
        outline: none;
        cursor: pointer;
        -moz-appearance: none;
        appearance: none;
        -webkit-appearance: none;
        border-radius: 5px;
        color: #fff;
        background-color: #7b68ee;
        box-shadow: 0 3px 8px 0 rgba(65, 105, 225, 0.18);
        display: inline-block;
        border: 0;
        padding: 10px 14px;
        font-size: 14px;
        transition: all 0.1s ease-in;
        margin: 15px;
    }
    .green {
        background-color: mediumseagreen;
    }
    .blue {
        background-color: royalblue;
    }
    .orange {
        background-color: orange;
    }
</style>
