<template>
    <div class="modal fade" id="addUpdateRole" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel" v-if="editing">Modifier Profile</h5>
                    <h5 class="modal-title" id="exampleModalLabel" v-else>Créer Nouveau Profile</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form class="form-horizontal" @submit.prevent @keydown="roleForm.errors.clear()">
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="name" class="col-sm-2 col-form-label">Titre</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="name" name="name" autocomplete="name" autofocus placeholder="Titre" v-model="roleForm.name">
                                    <span class="invalid-feedback d-block" role="alert" v-if="roleForm.errors.has('name')" v-text="roleForm.errors.get('name')"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="m_select" class="col-sm-2 col-form-label">Permission(s)</label>
                                <div class="col-sm-10">
                                    <multiselect
                                        id="m_select"
                                        v-model="roleForm.permissions"
                                        selected.sync="role.permissions"
                                        value=""
                                        :options="permissions"
                                        :searchable="true"
                                        :multiple="true"
                                        label="name"
                                        track-by="name"
                                        key="name"
                                        placeholder="Permission(s)"
                                    >
                                    </multiselect>
                                    <span class="invalid-feedback d-block" role="alert" v-if="roleForm.errors.has('permissions')" v-text="roleForm.errors.get('permissions')"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="description" class="col-sm-2 col-form-label">Description</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="description" name="description" required autocomplete="description" autofocus placeholder="Description" v-model="roleForm.description">
                                    <span class="invalid-feedback d-block" role="alert" v-if="roleForm.errors.has('description')" v-text="roleForm.errors.get('description')"></span>
                                </div>
                            </div>
                            <div class="form-group">
                            </div>
                        </div>
                    </form>

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                    <button type="button" class="btn btn-primary" @click="updateRole()" :disabled="!isValidCreateForm" v-if="editing">Enregistrer</button>
                    <button type="button" class="btn btn-primary" @click="createRole()" :disabled="!isValidCreateForm" v-else>Créer Profile</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect'

    class Role {
        constructor(role) {
            this.name = role.name || ''
            this.description = role.description || ''
            this.permissions = role.permissions || []
        }
    }
    export default {
        name: "addupdate",
        props: {

        },
        components: { Multiselect },
        mounted() {
            this.$parent.$on('create_new_role', () => {

                this.editing = false
                this.role = new Role({})
                this.roleForm = new Form(this.role)

                $('#addUpdateRole').modal()
            })

            this.$parent.$on('edit_role', ({ role }) => {
                console.log("role received to edit: ", role)
                this.editing = true
                this.role = new Role(role)
                this.roleForm = new Form(this.role)
                this.roleId = role.id

                $('#addUpdateRole').modal()
            })
        },
        created() {
            axios.get('/permissions')
                .then(({data}) => this.permissions = data);
        },
        data() {
            return {
                role: {},
                permissions: [],
                roleForm: new Form(new Role({})),
                roleId: null,
                editing: false,
                loading: false
            }
        },
        methods: {
            createRole() {
                this.loading = true

                this.roleForm
                    .post('/roles')
                    .then(newrole => {
                        this.loading = false
                        this.$parent.$emit('new_role_created', newrole)
                        $('#addUpdateRole').modal('hide')
                    }).catch(error => {
                    this.loading = false
                });
            },
            updateRole() {
                this.loading = true

                this.roleForm
                    .put(`/roles/${this.roleId}`,"")
                    .then(updrole => {
                        this.loading = false
                        this.$parent.$emit('role_updated', updrole)
                        $('#addUpdateRole').modal('hide')
                    }).catch(error => {
                    this.loading = false
                });
            }
        },
        computed: {
            isValidCreateForm() {
                return this.roleForm.name && !this.loading
            }
        }
    }
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
