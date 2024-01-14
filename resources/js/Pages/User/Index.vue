<template>

    <div v-if="users.length > 0" class="w-1/2 mx-auto py-6">
        <div class="message">
            <div class="message__text">
                <div v-for="user in users">
                    <a :href="`http://127.0.0.1:8000/users/${user.id}`" class="flex border-b border-3">
                        <p>{{ user.name }}</p>
                    </a>
                </div>
            </div>
            <div class="message__user"></div>
            <div class="message__date"></div>
        </div>
    </div>

</template>
<script>
    export default {
        name: "Index",
        props: [
            "users"
        ],
    }

</script>

<style scoped>

</style>
