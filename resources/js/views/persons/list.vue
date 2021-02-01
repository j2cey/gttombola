<template>
    <div>
        <div class="row align-items-center">
            <div class="col">
                <h1>Person List</h1>
            </div>
            <div class="col col-lg-1">
                <button
                    class="btn btn-secondary"
                    @click="deleteRow"
                    :disabled="this.$store.getters.selectedPerson.id == -1"
                >Delete</button>
            </div>
        </div>
        <table class="table table-hover">
            <thead>
            <tr>
                <th scope="col">Name (Job Title)</th>
                <th scope="col">Age</th>
                <th scope="col">Nickname</th>
                <th scope="col">Employee</th>
            </tr>
            </thead>
            <tbody>
            <tr
                v-for="person in this.$store.getters.persons"
                :key="person.id"
                @click="selectRow(person)"
                :class="{'table-primary' : isSelected(person.id)}"
            >
                <td scope="row">
                    {{ person.name }}
                    <span v-if="person.jobTitle != ''">({{ person.jobTitle }})</span>
                </td>
                <td>{{ person.age }}</td>
                <td>{{ person.nickname }}</td>
                <td>{{ person.employee }}</td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        name: "PersonList",
        methods: {
            selectRow(p) {
                this.$store.dispatch("selectPerson", p);
            },
            isSelected(id) {
                return id == this.$store.getters.selectedPerson.id;
            },
            deleteRow() {
                this.$store.dispatch(
                    "deletePerson",
                    this.$store.getters.selectedPerson.id
                );
            }
        }
    };
</script>
