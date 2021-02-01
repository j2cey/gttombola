<template>
    <div id="app" class="container mt-2">
        <person-list/>
        <hr>
        <person-details/>
    </div>
</template>

<script>
    import PersonList from "./list";
    import PersonDetails from "./details";

    import "bootstrap/dist/css/bootstrap.css";

    import store from "./store";

    export default {
        name: "person",
        store,
        components: {
            "person-list": PersonList,
            "person-details": PersonDetails
        }
    };
</script>
