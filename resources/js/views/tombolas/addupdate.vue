<template>
    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title" v-if="editing">Modifier Tombola</h3>
            <h3 class="card-title" v-else>Créer Nouvelle Tombola</h3>
        </div>
        <!-- /.card-header -->
        <!-- card-body -->

        <div class="modal-body">

            <form class="form-horizontal" @submit.prevent @keydown="tombolaForm.errors.clear()">

                <div class="form-group row">
                    <label for="titre" class="col-sm-2 col-form-label text-sm">Titre</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="titre" name="titre" autocomplete="titre" placeholder="Titre" v-model="tombolaForm.titre">
                        <span class="invalid-feedback d-block" role="alert" v-if="tombolaForm.errors.has('titre')" v-text="tombolaForm.errors.get('titre')"></span>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="fichier_reglement" class="col-sm-2 col-form-label text-sm"></label>
                    <div class="custom-file col-sm-10">
                        <input type="file" class="custom-file-input" id="fichier_reglement" name="fichier_reglement"  ref="fichier_reglement" @change="handleFileUpload">
                        <label class="custom-file-label text-muted" for="fichier_reglement">{{ fichierreglement_name }}</label>
                        <span class="invalid-feedback d-block" role="alert" v-if="tombolaForm.errors.has('fichier_reglement')" v-text="tombolaForm.errors.get('fichier_reglement')"></span>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="description" class="col-sm-2 col-form-label text-sm">Description</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="description" name="description" autocomplete="description" placeholder="Description" v-model="tombolaForm.description">
                        <span class="invalid-feedback d-block" role="alert" v-if="tombolaForm.errors.has('description')" v-text="tombolaForm.errors.get('description')"></span>
                    </div>
                </div>

                <div class="attachment-block clearfix">

                    <h6 class="attachment-heading">Paramètres & Base Participation</h6>
                    <br>

                    <div class="attachment-pushed">

                        <div class="attachment-text">

                            <div class="form-group row">
                                <label for="separateur_colonnes" class="col-sm-2 col-form-label text-sm">Séparateur Colonnes</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="separateur_colonnes" name="separateur_colonnes" autocomplete="separateur_colonnes" placeholder="Séparateur colonnes" v-model="tombolaForm.separateur_colonnes">
                                    <span class="invalid-feedback d-block" role="alert" v-if="tombolaForm.errors.has('separateur_colonnes')" v-text="tombolaForm.errors.get('separateur_colonnes')"></span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="position_numero" class="col-sm-2 col-form-label text-sm">Position Numéro</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="position_numero" name="position_numero" autocomplete="position_numero" placeholder="Position Numéro" v-model="tombolaForm.position_numero">
                                    <span class="invalid-feedback d-block" role="alert" v-if="tombolaForm.errors.has('position_numero')" v-text="tombolaForm.errors.get('position_numero')"></span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="position_valeur" class="col-sm-2 col-form-label text-sm">Position Valeur</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="position_valeur" name="position_valeur" autocomplete="position_valeur" placeholder="Position Valeur" v-model="tombolaForm.position_valeur">
                                    <span class="invalid-feedback d-block" role="alert" v-if="tombolaForm.errors.has('position_valeur')" v-text="tombolaForm.errors.get('position_valeur')"></span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="participation_unique" class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-10">
                                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                        <input name="participation_unique" type="checkbox" class="custom-control-input" id="participation_unique" v-model="tombolaForm.participation_unique">
                                        <label class="custom-control-label" for="participation_unique">Participation Unique</label>
                                    </div>
                                </div>
                            </div>

                            <div  v-if="!tombolaForm.participation_unique">

                                <div class="row">
                                    <div class="col">
                                        <span class="text text-sm text-danger">Un numéro pourra apparaître plusieurs fois dans l urne</span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="participation_unite" class="col-sm-2 col-form-label text-sm"></label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" id="participation_unite" name="participation_unite" autocomplete="participation_unite" placeholder="Unité de Participation" v-model="tombolaForm.participation_unite">
                                        <span class="invalid-feedback d-block" role="alert" v-if="tombolaForm.errors.has('participation_unite')" v-text="tombolaForm.errors.get('participation_unite')"></span>
                                    </div>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" id="participation_valeurunitaire" name="participation_valeurunitaire" autocomplete="participation_valeurunitaire" placeholder="Valeur Unitaire" v-model="tombolaForm.participation_valeurunitaire">
                                        <span class="invalid-feedback d-block" role="alert" v-if="tombolaForm.errors.has('participation_valeurunitaire')" v-text="tombolaForm.errors.get('participation_valeurunitaire')"></span>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </form>

        </div>
        <!-- /.card-body -->
        <div class="card-footer justify-content-between">
            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Fermer</button>
            <button type="button" class="btn btn-warning btn-sm" @click="validerEtape()" :disabled="!isValidCreateForm">Valider</button>
        </div>
        <!-- /.card-footer -->

    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect'

    // eslint-disable-next-line no-unused-vars
    class Tombola {
        constructor(tombola) {
            this.titre = tombola.titre || ''
            this.fichier_reglement = tombola.fichier_reglement || ''
            this.description = tombola.description || ''
            this.separateur_colonnes = tombola.separateur_colonnes || ';'
            this.position_numero = tombola.position_numero || 1
            this.position_valeur = tombola.position_valeur || -1
            this.participation_unique = tombola.participation_unique || true
            this.participation_unite = tombola.participation_unite || ''
            this.participation_valeurunitaire = tombola.participation_valeurunitaire || ''
        }
    }
    export default {
        name: "addupdate",
        props: {
        },
        // eslint-disable-next-line vue/no-unused-components
        components: { Multiselect },
        mounted() {
        },
        created() {
        },
        data() {
            return {
                tombola: {},
                // eslint-disable-next-line no-undef
                tombolaForm: new Form(new Tombola({})),
                tombolaId: null,
                editing: false,
                loading: false,
                fichierreglement_name: 'Télécharger le fichier de règlement',
                fichierreglement_selected : null
            }
        },
        methods: {
            valider() {
                this.$emit('create_new_workflow')
            },
            handleFileUpload(event) {
                this.fichierreglement_selected = event.target.files[0];
                this.fichierreglement_name = event.target.name;
                this.fichierreglement_name = (typeof this.fichierreglement_selected !== 'undefined') ? this.fichierreglement_selected.name : 'Télécharger le fichier de règlement';
            },
            validerEtape() {
                this.createTombola();
            },
            rejeterEtape() {
                this.$emit('validate_reject')
            },
            createTombola() {
                const fd = new FormData();
                fd.append('fichier_reglement', this.fichierreglement_selected);
                this.tombolaForm
                    .post(`/tombolas`, fd)
                    .then(data => {
                        //this.updateData(data);
                        console.log("etape_traitee: ",data)
                        window.noty({
                            message: 'Tombola créé avec succès',
                            type: 'success'
                        }).then(() => {
                            window.location = '/tombolas'
                        })
                        // eslint-disable-next-line no-unused-vars
                    }).catch(error => {
                    this.loading = false
                });
            },
            addFileToForm(fieldname) {
                if (typeof this.selectedFile !== 'undefined') {
                    const fd = new FormData();
                    fd.append(fieldname, this.selectedFile);
                    //console.log("image added", fd);
                    return fd;
                } else {
                    const fd = undefined;
                    //console.log("image not added", fd);
                    return fd;
                }
            },
            updateData(data) {
                window.noty({
                    message: 'Traitement effectué avec succès',
                    type: 'success'
                })
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
