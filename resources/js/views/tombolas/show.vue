<template>
    <div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">

                        <!-- Main content -->
                        <div class="invoice p-3 mb-3">
                            <!-- title row -->
                            <div class="row">
                                <div class="col-12">
                                    <h4>
                                        <i class="fas fa-globe"></i> {{ tombola.titre }}
                                        <small class="float-right">Date Création: {{tombola.created_at | formatDate}}</small>
                                    </h4>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- info row -->
                            <div class="row invoice-info">
                                <div class="col-sm-4 invoice-col">
                                    <address>
                                        <strong>Description:</strong><br>
                                        {{ tombola.description }}
                                    </address>
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-4 invoice-col">

                                </div>
                                <!-- /.col -->
                                <div class="col-sm-4 invoice-col">

                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->

                            <!-- Table row -->
                            <div class="row">
                                <div class="col">
                                    <strong>Urnes</strong>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 table-responsive">
                                    <table class="table table-striped text-sm">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Titre</th>
                                            <th>Type</th>
                                            <th>Description</th>
                                            <th>NB. Participants</th>
                                            <th>NB. Participations</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td><input type="checkbox"
                                                       :value="tombola.urneprincipales[0].uuid"
                                                       id="mainCat.merchantId"
                                                       v-model="checkedUrnes"
                                                       @change="checkUrne($event)"></td>
                                            <td>{{ tombola.urneprincipales[0].titre }}</td>
                                            <td>{{ tombola.urneprincipales[0].typeurne.titre }}</td>
                                            <td>{{ tombola.urneprincipales[0].description }}</td>
                                            <td>{{ tombola.urneprincipales[0].participants.length }}</td>
                                            <td>{{ tombola.urneprincipales[0].participations.length }}</td>
                                        </tr>
                                        <tr v-for="urnesec in tombola.urnesecondaires" :key="urnesec.id">
                                            <td><input type="checkbox"
                                                       :value="urnesec.uuid"
                                                       id="urnesec.uuid"
                                                       v-model="checkedUrnes"
                                                       @change="checkUrne($event)"></td>
                                            <td>{{ urnesec.titre }}</td>
                                            <td>{{ urnesec.typeurne.titre }}</td>
                                            <td>{{ urnesec.description }}</td>
                                            <td>{{ urnesec.participants.length }}</td>
                                            <td>{{ urnesec.participations.length }}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.col -->
                            </div>
                            <div class="row no-print">
                                <div class="col-12">
                                    <button type="button" class="btn btn-sm btn-warning float-right" :disabled="!canDoTirage" @click="AddNewTirage(tombola,checkedUrnes)"><i class="fa fa-share-alt"></i>
                                        Effectuer Tirage
                                    </button>
                                </div>
                            </div>
                            <!-- /.row -->

                            <div class="row">
                                <!-- accepted payments column -->
                                <div class="col-6">

                                    <p class="lead">Résultat Chargement de Base</p>

                                    <div class="table-responsive">
                                        <table class="table text-sm">
                                            <tr>
                                                <th style="width:50%">Date:</th>
                                                <td>{{ lastbaseresult_created }}</td>
                                            </tr>
                                            <tr>
                                                <th>Début:</th>
                                                <td>{{ lastbaseresult_importstart }}</td>
                                            </tr>
                                            <tr>
                                                <th>Fin:</th>
                                                <td>{{ lastbaseresult_importend }}</td>
                                            </tr>
                                            <tr>
                                                <th>Lignes Traitées:</th>
                                                <td>{{ lastbaseresult_processing }}</td>
                                            </tr>
                                            <tr>
                                                <th>Progression:</th>
                                                <td>{{ lastbaseresult ? lastbaseresult.import_rate + ' %' : "" }}</td>
                                            </tr>
                                        </table>
                                    </div>

                                </div>
                                <!-- /.col -->

                                <div class="col-6">
                                    <p class="lead">Résultat Dernier Tirage</p>

                                    <div class="table-responsive">
                                        <table class="table text-sm">
                                            <tr>
                                                <th style="width:50%">Titre:</th>
                                                <td>{{ derniertirage ? derniertirage.titre : '' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Description:</th>
                                                <td>{{ derniertirage ? derniertirage.description : '' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Nombre à Tirer:</th>
                                                <td>{{ derniertirage ? derniertirage.nombre_a_tirer : '' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Résultat:</th>
                                                <td v-if="derniertirage">
                                                    <span v-for="resultat in derniertirage.resultats" :key="resultat.id" class="badge badge-warning">
                                                        {{ resultat.participant.numero }}
                                                    </span>
                                                </td>
                                                <td v-else>

                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->

                            <!-- this row will not appear when printing -->
                            <div class="row no-print">
                                <div class="col-12">
                                    <button type="button" class="btn btn-sm btn-success float-right" style="margin-right: 5px;" @click="AddNewBaseParticipation(tombola)">
                                        <i class="fas fa-download"></i> Charger Nouvelle Base
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- /.invoice -->
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <AddBaseParticipation></AddBaseParticipation>
        <AddTirage></AddTirage>
    </div>
</template>

<script>
    import moment from 'moment'
    import AddBaseParticipation from './addparticipations'
    import AddTirage from './addtirage'
    export default {
        name: "show",
        props: {
            tombola_prop: {},
        },
        components: {
            AddBaseParticipation, AddTirage
        },
        mounted() {
            this.$on('new_tirage_added', (tirage) => {
                console.log('new_tirage_added', tirage)
                window.noty({
                    message: 'Tirage effectué avec succès',
                    type: 'success'
                })
                // insert la nouvelle workflow dans le tableau des workflows
                this.derniertirage = tirage
            })
        },
        data() {
            return {
                tombola: this.tombola_prop,
                lastbaseimportresult: this.tombola_prop.importfileresult,//this.tombola_prop.lastbaseparticipation ? this.tombola_prop.lastbaseparticipation.importfileresult : null
                checkedUrnes: [],
                derniertirage: null
            };
        },
        methods: {
            AddNewBaseParticipation(tombola) {
                this.$emit('add_new_baseparticipation', { tombola })
            },
            AddNewTirage(tombola, urnes) {
                this.$emit('add_new_tirage', { tombola, urnes })
            },
            checkUrne(event) {
                //console.log(event)
                console.log(this.checkedUrnes)
            },
        },
        computed: {
            canDoTirage() {
                return this.checkedUrnes.length > 0;
            },
            lastbaseresult() {
                return this.lastbaseimportresult
            },
            lastbaseresult_created() {
                return this.lastbaseimportresult ? moment(String(this.lastbaseimportresult.created_at)).format('DD/MM/YYYY hh:mm') : ""
            },
            lastbaseresult_importstart() {
                return this.lastbaseimportresult ? moment(String(this.lastbaseimportresult.importstart_at)).format('DD/MM/YYYY hh:mm') : ""
            },
            lastbaseresult_importend() {
                return this.lastbaseimportresult && this.lastbaseimportresult.importend_at ? moment(String(this.lastbaseimportresult.importend_at)).format('DD/MM/YYYY hh:mm') : ""
            },
            lastbaseresult_processing() {
                return this.lastbaseimportresult ? this.lastbaseimportresult.nb_import_processed + ' / ' + this.lastbaseimportresult.nb_to_import : ""
            },
        }
    }
</script>

<style scoped>

</style>
