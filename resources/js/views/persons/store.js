import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);

function createEmptyPerson() {
    return {
        id: -1,
        name: "",
        jobTitle: "",
        age: "",
        nickname: "",
        employee: false
    };
}

export default new Vuex.Store({
    strict: true,
    state: {
        persons: [],
        selectedPerson: createEmptyPerson(),
        nextId: 1
    },
    mutations: {
        ADD_PERSON(state, person) {
            person.id = state.nextId++;
            state.persons.push(person);
            state.selectedPerson = person;
        },
        SELECT_PERSON(state, person) {
            state.selectedPerson = person;
        },
        DELETE_PERSON(state, id) {
            if (state.selectedPerson.id == id) {
                state.selectedPerson = createEmptyPerson();
            }
            state.persons = state.persons.filter(p => p.id != id);
        },
        UPDATE_PERSON(state, person) {
            var store_p = state.persons.find(p => p.id == person.id);
            if (store_p != null) {
                store_p.name = person.name;
                store_p.nickname = person.nickname;
                store_p.jobTitle = person.jobTitle;
                store_p.age = person.age;
                store_p.employee = person.employee;
            }
        }
    },
    actions: {
        addPerson(context, person) {
            context.commit("ADD_PERSON", person);
        },
        selectPerson(context, person) {
            context.commit("SELECT_PERSON", person);
        },
        deletePerson(context, id) {
            context.commit("DELETE_PERSON", id);
        },
        updatePerson(context, person) {
            context.commit("UPDATE_PERSON", person);
        }
    },
    getters: {
        persons(state) {
            return state.persons;
        },
        selectedPerson(state) {
            return state.selectedPerson;
        }
    }
});
