<template>
        <div class="w-1/2 mx-auto">
            <div class="users__title">
                <h1 class="text-center py-5">Contacts</h1>
            </div>
            <div v-if="users.length > 0" class="py-6">
                <div class="users">
                    <div v-for="user in users" class="user__item">
                        <a :href="`http://127.0.0.1:8000/messages/${user.id}`" class="flex border-b border-3 py-3">
                            <p>{{ user.name }}</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
</template>
<script>
    export default {
        name: "Index",
        props: [
            "users",
        ],
    }
</script>

<style scoped>

</style>
