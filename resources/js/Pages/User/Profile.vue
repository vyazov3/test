<template>
    <div>
        {{ user.id }}<br>
        {{ user.name }}<br>


    </div>
</template>

<script>
    export default {
        name: "Profile",
        props: [
            "user"
        ],
    }

</script>

<style scoped>

</style>
