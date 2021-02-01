<template>
    <div class="no">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark"> Dashboard</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->

        <section class="content">
            <div class="container-fluid">
                <h5 class="mb-2">Bordereaux Par Etat</h5>
                <div class="row">
                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-success"><i class="far fa-flag"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Validés</span>
                                <span class="info-box-number">{{ rawstats.all_par_etat ? rawstats.all_par_etat.state_3 : 0 }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-primary"><i class="far fa-copy"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Validés - Ecart Positif</span>
                                <span class="info-box-number">{{ rawstats.all_par_etat ? rawstats.all_par_etat.state_4 : 0 }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-warning"><i class="far fa-copy"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Validés - Ecart Négatif</span>
                                <span class="info-box-number">{{ rawstats.all_par_etat ? rawstats.all_par_etat.state_5 : 0 }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-danger"><i class="far fa-window-close"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Rejétés</span>
                                <span class="info-box-number">{{ rawstats.all_par_etat ? rawstats.all_par_etat.state_6 : 0 }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-info"><i class="fa fa-cogs"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">En Cours Traitement</span>
                                <span class="info-box-number">{{ rawstats.all_par_etat ? rawstats.all_par_etat.state_2 : 0 }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-secondary"><i class="far fa-question-circle"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Attente Traitement</span>
                                <span class="info-box-number">{{ rawstats.all_par_etat ? rawstats.all_par_etat.state_1 : 0 }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
                <!-- =========================================================== -->
                <!-- Info Box -->
                <h5 class="mt-4 mb-2">Traitements par Etape</h5>
                <div class="row">
                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="info-box bg-warning">
                            <span class="info-box-icon"><i class="far fa-calendar-alt"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Agences</span>
                                <span class="info-box-number">{{ rawstats.all_par_etape.step_0 ? rawstats.all_par_etape.step_0.reste : 0 }}</span>

                                <div class="progress">
                                    <div class="progress-bar" :style="{ width: rawstats.all_par_etape.step_0.rate + '%' }"></div>
                                </div>
                                <span class="progress-description">A Traiter</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="info-box bg-info">
                            <span class="info-box-icon"><i class="far fa-bookmark"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Finances</span>
                                <span class="info-box-number">{{ rawstats.all_par_etape.step_1.reste }}</span>

                                <div class="progress">
                                    <div class="progress-bar" :style="{ width: rawstats.all_par_etape.step_1.rate + '%' }"></div>
                                </div>
                                <span class="progress-description">A Traiter</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="info-box bg-success">
                            <span class="info-box-icon"><i class="far fa-thumbs-up"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Terminés</span>
                                <span class="info-box-number">{{ rawstats.all_par_etape.step_end.total }}</span>

                                <div class="progress">
                                    <div class="progress-bar" :style="{ width: rawstats.all_par_etape.step_end.rate + '%' }"></div>
                                </div>
                                <span class="progress-description">Traité(s)</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

                <!-- Small Box (Stat card) -->
                <div class="row">
                    <div class="col">
                        <h5 class="mb-2 mt-4">Détails Par Agence</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <multiselect
                            id="m_select_workflow_object"
                            v-model="agenceForm.agences"
                            selected.sync="agenceForm.agences"
                            value=""
                            :options="agences"
                            :searchable="true"
                            :multiple="false"
                            label="titre"
                            track-by="id"
                            key="id"
                            placeholder="Agence"
                            @select="onSelectAgence"
                        >
                        </multiselect>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-success"><i class="far fa-flag"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Validés</span>
                                <span class="info-box-number">{{ agenceParEtat ? agenceParEtat.state_3 : 0 }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-primary"><i class="far fa-copy"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Validés - Ecart Positif</span>
                                <span class="info-box-number">{{ agenceParEtat ? agenceParEtat.state_4 : 0 }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-warning"><i class="far fa-copy"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Validés - Ecart Négatif</span>
                                <span class="info-box-number">{{ agenceParEtat ? agenceParEtat.state_5 : 0 }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-danger"><i class="far fa-window-close"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Rejétés</span>
                                <span class="info-box-number">{{ agenceParEtat ? agenceParEtat.state_6 : 0 }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-info"><i class="fa fa-cogs"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">En Cours Traitement</span>
                                <span class="info-box-number">{{ agenceParEtat ? agenceParEtat.state_2 : 0 }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-secondary"><i class="far fa-question-circle"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Attente Traitement</span>
                                <span class="info-box-number">{{ agenceParEtat ? agenceParEtat.state_1 : 0 }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

                <!-- =========================================================== -->

            </div><!-- /.container-fluid -->
        </section>


        <!-- /.content -->

    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect'

    export default {
        name: "index",
        components: { Multiselect },
        created() {
            axios.get('/dashboards/fetch')
                .then(({data}) => this.rawstats = data);

            axios.get('/bordereauremiselocs.fetch')
                .then(({data}) => this.agences = data);
        },
        data() {
            return {
                agences: [],
                agenceForm: new Form({agences: null}),
                agenceParEtat: {
                    state_1: 0,
                    state_2: 0,
                    state_3: 0,
                    state_4: 0,
                    state_5: 0,
                    state_6: 0
                },
                rawstats: {
                    all_par_etat: {
                        state_1: 0,
                        state_2: 0,
                        state_3: 0,
                        state_4: 0,
                        state_5: 0,
                        state_6: 0
                    },
                    all_par_etape:
                        {
                            step_0:
                                { total: 0, reste: 0, rate: 0 },
                            step_1:
                                { total: 0, reste: 0, rate: 0 },
                            step_end:
                                { total: 0, reste: 0, rate: 0 }
                        }
                }
            }
        },
        methods: {
            onSelectAgence(value) {
                //console.log('selected value: ', value);
                //console.log('agenceForm : ', this.agenceForm);
                //`/smscampaigns/${this.campaignId}`
                axios.get(`/dashboards/fetchagence/${value.id}`)
                    .then(({data}) => this.agenceParEtat = data);
            },
        }
    }
</script>

<style scoped>

</style>
