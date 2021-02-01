<template>
    <div>

        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Profiles Utilisateurs</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item active">Profiles Utilisateurs</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">

                <div class="card card-default">
                    <div class="card-header">
                        <div class="form-inline float-left">
                            <span class="help-inline pr-1"> Liste des Profiles d'utilisateur </span>
                            <button class="btn btn-xs btn-primary" @click="createNewRole()">Nouveau</button>
                        </div>

                        <div class="card-tools">

                            <div class="input-group input-group-sm" style="width: 150px;">
                                <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div id="rolelist">

                            <div class="card card-widget" v-for="(role, index) in roles" v-if="roles">
                                <div class="card-header">
                                    <div class="user-block">
                                        <span class="text-green" data-toggle="collapse" data-parent="#rolelist" :href="'#collapse-roles-'+index">
                                            {{ role.name }}
                                        </span>
                                    </div>
                                    <!-- /.user-block -->
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-toggle="tooltip" @click="editRole(role)">
                                            <i class="fa fa-pencil-alt"></i></button>
                                        <button type="button" class="btn btn-tool" data-toggle="collapse" data-parent="#rolelist" :href="'#collapse-roles-'+index"><i class="fas fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" @click="deleteRole(role.id, index)"><i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                    <!-- /.card-tools -->
                                </div>
                                <!-- /.card-header -->
                                <div :id="'collapse-roles-'+index" class="panel-collapse collapse in">
                                    <div class="card-body" >

                                        <div class="row">
                                            <div class="col-md-3 col-sm-6 col-12">
                                                <div class="info-box">

                                                    <div class="info-box-content">
                                                        <dt>Description</dt>
                                                        <dd>{{ role.description }}</dd>
                                                        <dt>Date Création</dt>
                                                        <dd>{{ role.created_at | formatDate}}</dd>
                                                        <dd class="col-sm-8 offset-sm-4"></dd>
                                                    </div>
                                                    <!-- /.info-box-content -->
                                                </div>
                                                <!-- /.info-box -->
                                            </div>
                                            <!-- /.col -->
                                            <div class="col-md-9 col-sm-6 col-12">

                                                <div class="card card-default">
                                                    <div class="card-header">
                                                        <div class="form-inline float-left">
                                                            <span class="help-inline pr-1"> Permissions du Profile </span>
                                                        </div>
                                                    </div>
                                                    <!-- /.card-header -->
                                                    <div class="card-body">
                                                        <label v-for="(perm, index) in role.permissions">
                                                            <span class="badge badge-danger" v-if="perm.level == 1">{{ perm.name }}</span>
                                                            <span class="badge badge-warning" v-else-if="perm.level == 2">{{ perm.name }}</span>
                                                            <span class="badge badge-primary" v-else-if="perm.level == 3">{{ perm.name }}</span>
                                                            <span class="badge badge-success" v-else>{{ perm.name }}</span>
                                                            &nbsp;
                                                        </label>
                                                    </div>
                                                    <!-- /.card-body -->
                                                    <div class="card-footer">
                                                    </div>
                                                </div>

                                            </div>
                                            <!-- /.col -->

                                        </div>

                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>

                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        .
                    </div>
                </div>
                <!-- /.card -->

                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->

        <AddUpdateRole></AddUpdateRole>
    </div>
</template>

<script>
    import AddUpdateRole from './addupdate'
    import PermissionDisplay from '../permissions/display'
    export default {
        name: "index",
        mounted() {
            this.$on('new_role_created', (role) => {
                window.noty({
                    message: 'Profile créé avec succès',
                    type: 'success'
                })
                // insert la nouveau role dans le tableau des roles
                this.roles.push(role)
            })

            this.$on('role_updated', (role) => {
                // on récupère l'index de le role modifié
                let roleIndex = this.roles.findIndex(c => {
                    return role.id == c.id
                })

                this.roles.splice(roleIndex, 1, role)
                window.noty({
                    message: 'Profile modifié avec succès',
                    type: 'success'
                })

            })
        },
        components: {
            AddUpdateRole, PermissionDisplay
        },
        data() {
            return {
                roles: []
            }
        },
        created() {
            axios.get('/roles')
                .then(({data}) => this.roles = data);
        },
        methods: {
            createNewRole() {
                this.$emit('create_new_role')
            },
            editRole(role) {
                console.log("role to edit: ", role)
                this.$emit('edit_role', { role })
            },
            deleteRole(id, key) {
                if(confirm('Voulez-vous vraiment supprimer ?')) {
                    axios.delete(`/roles/${id}`)
                        .then(resp => {
                            this.roles.splice(key, 1)
                            window.noty({
                                message: 'Campagne supprimée avec succès',
                                type: 'success'
                            })
                        }).catch(error => {
                        window.handleErrors(error)
                    })
                }
            }
        }
    }
</script>

<style scoped>

</style>
