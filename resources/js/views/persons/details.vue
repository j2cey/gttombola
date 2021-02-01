<template>
    <div class="row">
        <div class="col col-lg-1">
            <button class="btn btn-secondary" @click="newPerson">New</button>
        </div>
        <div class="col">
            <form>
                <fieldset>
                    <legend>Details</legend>

                    <input type="hidden" id="id" :value="selectedPerson.id">

                    <div class="form-group">
                        <label for="name">Name</label>
                        <input class="form-control" type="text" id="name" :value="selectedPerson.name">
                    </div>

                    <div class="form-group">
                        <label for="nickname">NickName</label>
                        <input class="form-control" type="text" id="nickname" :value="selectedPerson.nickname">
                    </div>

                    <div class="form-group">
                        <label for="jobTitle">Job Title</label>
                        <input class="form-control" type="text" id="jobTitle" :value="selectedPerson.jobTitle">
                    </div>
                    <div class="form-group">
                        <label for="Age">Age</label>
                        <input class="form-control" type="text" id="age" :value="selectedPerson.age">
                    </div>
                    <div class="form-group form-check">
                        <input
                            class="form-check-input"
                            type="checkbox"
                            id="employee"
                            :checked="selectedPerson.employee"
                        >
                        <label class="form-check-label" for="Employee">Employee</label>
                    </div>

                    <button type="submit" class="btn btn-primary" @click.prevent="savePerson">Save</button>
                </fieldset>
            </form>
        </div>
    </div>
</template>

<script>
    import { mapState } from "vuex";

    export default {
        name: "PersonDetails",
        methods: {
            newPerson() {
                const p = {
                    name: "New Person",
                    jobTitle: "",
                    age: "",
                    nickname: "",
                    employee: false
                };
                this.$store.dispatch("addPerson", p);
            },
            savePerson(event) {
                const p = {
                    id: event.target.form["id"].value,
                    name: event.target.form["name"].value,
                    nickname: event.target.form["nickname"].value,
                    jobTitle: event.target.form["jobTitle"].value,
                    age: event.target.form["age"].value,
                    employee: event.target.form["employee"].checked
                };
                this.$store.dispatch("updatePerson", p);
            }
        },
        computed: {
            ...mapState({
                selectedPerson: state => state.selectedPerson
            })
        }
    };
</script>
