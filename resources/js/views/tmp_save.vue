<template>

    <div class="col">

        <draggable tag="ul" :list="workflowsteps"
                   :disabled="!enabled"
                   @change="orderChanged"
                   @start="dragging = true"
                   @end="dragging = false"
                   class="list-group todo-list" handle=".handle" data-widget="todo-list"
        >
            <li
                class="list-group-item"
                v-for="(element, idx) in workflowsteps"
                :key="element.id"
            >
                <i class="fa fa-align-justify handle"></i>

                <span class="text">{{ element.titre }}</span>
                <!-- Emphasis label -->
                <small class="badge badge-pill badge-warning"><i class="fa fa-user"></i> {{ element.profile.name }}</small>


                <!-- General tools such as edit or delete-->
                <div class="tools">
                    <i class="fa fa-edit" @click="editWorkflowstep(element)"></i>
                    <i class="fa fa-trash"></i>
                </div>

                <!-- Action(s) de l'Etape -->
                <div class="card card-default">
                    <div class="card-header">
                        <div class="form-inline float-left">
                            <span class="help-inline pr-1"> Action(s) de l'Etape </span>

                            <button class="btn btn-xs btn-success" @click="createNewAction(element.id, idx)">
                                <i class="fa fa-plus" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        <WorkflowActions :workflowstepid_prop="element.id" :workflowactions_prop="element.actions"></WorkflowActions>

                    </div>

                </div>
                <!-- / Action(s) de l'Etape -->

            </li>
        </draggable>

        <AddUpdateAction></AddUpdateAction>
    </div>

</template>

<script>
    import EventBusWfl from '../eventBus'
    import EventBusStp from './eventBus'
    import AddUpdateAction from './actions/addupdate'
    import WorkflowActions from './actions/actions'
    let id = 3;
    import draggable from 'vuedraggable'

    export default {
        props: {
            workflowId: "",
            workflowsteps_prop: {}
        },
        name: "steps",
        display: "Handle",
        instruction: "Drag using the handle icon",
        order: 5,
        components: {
            draggable, AddUpdateAction, WorkflowActions
        },
        mounted() {
            EventBusWfl.$on('workflowstep_to_add', (add_data) => {
                // Step créée à insérer sur la liste
                console.log('workflowstep_to_add from parent', add_data)
                if (this.workflowId == add_data.workflowId) {
                    this.createStep(add_data.workflowstep)
                }
            })

            EventBusWfl.$on('workflowstep_to_update', (upd_data) => {
                // Step modifiée à mettre à jour sur la liste
                if (this.workflowId == upd_data.workflowId) {
                    this.updateStep(upd_data.workflowstep)
                }
            })

            this.$on('workflowaction_created', (workflowaction, workflowstepId) => {
                // recoit nouvelle action créée
                EventBusStp.$emit('workflowaction_to_add', {workflowaction, workflowstepId})
            })
        },
        data() {
            return {
                workflowsteps: this.workflowsteps_prop,
                enabled: true,
                list: [
                    { name: "John", text: "", id: 0 },
                    { name: "Joao", text: "", id: 1 },
                    { name: "Jean", text: "", id: 2 }
                ],
                dragging: false
            };
        },
        computed: {
            draggingInfo() {
                console.log(this.dragging ? "under drag" : "");
            }
        },
        methods: {
            createNewAction(workflowstepId, key) {
                console.log('create_new_workflowaction--sent', workflowstepId, key)
                this.$emit('create_new_workflowaction', workflowstepId)
            },
            createNewAction(workflowstepId, key) {
                console.log('rely_create_new_workflowaction--sent', workflowstepId, key)
                //this.$emit('create_new_workflowaction', workflowstepId)
                this.$parent.$emit('rely_create_new_workflowaction', workflowstepId, key)
            },
            removeAt(idx) {
                this.list.splice(idx, 1);
            },
            add: function() {
                id++;
                this.list.push({ name: "Juan " + id, id, text: "" });
            },
            orderChanged(evt) {
                window.console.log(evt, evt.moved.element, evt.moved.oldIndex, evt.moved.newIndex);
                let changeForm = new Form({
                    'titre': evt.moved.element.titre,
                    'description': evt.moved.element.description,
                    'workflow_id': evt.moved.element.workflow_id,
                    'profile': evt.moved.element.profile,
                    'posi': evt.moved.newIndex,
                    'oldIndex': evt.moved.oldIndex,
                    'newIndex': evt.moved.newIndex,
                });
                changeForm
                    .put(`/workflowsteps/${evt.moved.element.uuid}`)
                    .then(workflowsteps => {
                        this.workflowsteps = workflowsteps;
                    }).catch(error => {
                    this.loading = false
                });
            },
            createStep(workflowstep) {
                window.noty({
                    message: 'Etape créée avec succès',
                    type: 'success'
                })

                this.workflowsteps.push(workflowstep)
            },
            updateStep(workflowstep) {
                // on récupère l'index de session modifiée
                let stepIndex = this.workflowsteps.findIndex(s => {
                    return workflowstep.id == s.id
                })

                this.workflowsteps.splice(stepIndex, 1, workflowstep)
                window.noty({
                    message: 'Etape modifiée avec succès',
                    type: 'success'
                })
            }
        }
    };
</script>
<style scoped>
    .button {
        margin-top: 35px;
    }
    .handle {
        float: left;
        padding-top: 8px;
        padding-bottom: 8px;
    }
    .close {
        float: right;
        padding-top: 8px;
        padding-bottom: 8px;
    }
    input {
        display: inline-block;
        width: 50%;
    }
    .text {
        margin: 20px;
    }
</style>
