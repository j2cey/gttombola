<template>
    <div>
        <label class="badge badge-danger" v-if="permission.level == 1">{{ permission.name }}</label>
        <label class="badge badge-warning" v-else-if="permission.level == 2">{{ permission.name }}</label>
        <label class="badge badge-primary" v-else-if="permission.level == 3">{{ permission.name }}</label>
        <label class="badge badge-success" v-else>{{ permission.name }}</label>
    </div>
</template>

<script>
    export default {
        name: "display",
        props: {
            permission: {}
        }
    }
</script>

<style scoped>

</style>
