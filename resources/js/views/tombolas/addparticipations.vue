<template>
    <div class="modal fade" id="addBaseParticipation" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Charger Nouvelle Base Participations</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form class="form-horizontal" @submit.prevent @keydown="baseparticipationForm.errors.clear()">
                        <div class="card-body">

                            <div class="form-group row">
                                <label for="fichier" class="col-sm-2 col-form-label text-sm"></label>
                                <div class="custom-file col-sm-10">
                                    <input type="file" class="custom-file-input" id="fichier" name="fichier"  ref="fichier" @change="handleFileUpload">
                                    <label class="custom-file-label text-muted" for="fichier">{{ fichier_name }}</label>
                                    <span class="invalid-feedback d-block" role="alert" v-if="baseparticipationForm.errors.has('fichier')" v-text="tombolaForm.errors.get('fichier')"></span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="separateur_colonnes" class="col-sm-2 col-form-label text-sm">Separateur Colonnes</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="separateur_colonnes" name="separateur_colonnes" required autocomplete="separateur_colonnes" autofocus placeholder="Separateur Colonnes" v-model="baseparticipationForm.separateur_colonnes">
                                    <span class="invalid-feedback d-block" role="alert" v-if="baseparticipationForm.errors.has('separateur_colonnes')" v-text="baseparticipationForm.errors.get('separateur_colonnes')"></span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="entete_premiere_ligne" class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-10">
                                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                        <input name="entete_premiere_ligne" type="checkbox" class="custom-control-input" id="entete_premiere_ligne" v-model="baseparticipationForm.entete_premiere_ligne">
                                        <label class="custom-control-label" for="entete_premiere_ligne">En-tete Colonnes ?</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="vider_urnes" class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-10">
                                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                        <input name="vider_urnes" type="checkbox" class="custom-control-input" id="vider_urnes" v-model="baseparticipationForm.vider_urnes">
                                        <label class="custom-control-label" for="vider_urnes">Vider Urnes avant ?</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Fermer</button>
                    <button type="button" class="btn btn-sm btn-primary" @click="createBaseParticipation()" :disabled="!isValidCreateForm">Charger La Base</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</template>

<script>
    class BaseParticipation {
        constructor(baseparticipation,tombola,separateur_colonnes) {
            this.fichier = baseparticipation.fichier || ''
            this.separateur_colonnes = baseparticipation.separateur_colonnes || separateur_colonnes//this.tombola.parametreparticipation.separateur_colonnes
            this.entete_premiere_ligne = baseparticipation.entete_premiere_ligne || false
            this.vider_urnes = baseparticipation.vider_urnes || false
            this.tombola_id = baseparticipation.tombola_id || tombola.id
        }
    }
    export default {
        name: "addparticipations",
        props: {
        },
        components: {},
        mounted() {
            this.$parent.$on('add_new_baseparticipation', ({ tombola }) => {
                console.log('add_new_baseparticipation', tombola)
                this.tombola = tombola
                this.editing = false
                this.baseparticipation = new BaseParticipation({}, tombola, tombola.parametreparticipation.separateur_colonnes)
                this.baseparticipationForm = new Form(this.baseparticipation)
                $('#addBaseParticipation').modal()
            })
        },
        created() {
        },
        data() {
            return {
                baseparticipation: {},
                baseparticipationForm: new Form(new BaseParticipation({}, {}, '')),
                tombola: null,
                editing: false,
                loading: false,
                fichier_name: "Selectionner le fichier de Base",
                fichier_selected : null
            }
        },
        methods: {
            handleFileUpload(event) {
                this.fichier_selected = event.target.files[0];
                this.fichier_name = event.target.name;
                this.fichier_name = (typeof this.fichier_selected !== 'undefined') ? this.fichier_selected.name : 'Selectionner le fichier de Base';
            },
            createBaseParticipation() {
                this.loading = true
                const fd = new FormData();
                fd.append('fichier', this.fichier_selected);
                this.baseparticipationForm
                    .post('/baseparticipations', fd)
                    .then(newbaseparticipation => {
                        this.loading = false
                        this.$parent.$emit('new_baseparticipation_added', newbaseparticipation)
                        $('#addBaseParticipation').modal('hide')
                    }).catch(error => {
                    this.loading = false
                });
            },
        },
        computed: {
            isValidCreateForm() {
                return !this.loading
            }
        }
    }
</script>

<style scoped>

</style>
