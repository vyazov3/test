<template>
    
    <div v-if="users.length > 0" class="w-1/2 mx-auto py-6">
        <div class="message">
            <div class="message__text">
                <a href="#" class="flex border-b border-3" v-for="user in users">
                    <p>{{ user.name }}</p>
                </a>
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