<template>
    <div class="message__title w-1/2 mx-auto py-6">
        Messages
    </div>
    <div v-if="messages.length > 0" class="w-1/2 mx-auto py-6">
        <div class="message">
            <div class="message__text">
                <div class="flex border-b border-3" v-for="message in messages">
                    <div class="message__user">{{ message.name }}.</div>
                    <div class="message__text">{{ message.message }}.</div>
                    <div class="message__time text-right">{{ message.time }}</div>
                </div>
<!--                Участники-->
<!--                <div v-for="user in users">-->
<!--                    {{ user.name }}-->
<!--                </div>-->
            </div>
        </div>
    </div>
    <div v-else class="w-1/2 mx-auto py-6">
        <div class="message__error">
            Oooooops, история сообщений отсутствует. Напишите первым!
        </div>
    </div>
    <div class="w-1/2 mx-auto py-6">
        <div class="flex">
            <input v-model="message" class="border border-dark rounded-lg" type="text" placeholder="Write msg...">
            <a @click.prevent="store" href="#" class="bg-sky-400 text-white text-center p-5 ml-2 rounded-lg">Send</a>
        </div>
    </div>
</template>
<script>
import axios from 'axios';
    export default {
        name: "Index",
        props: [
            "messages",
        ],
        data() {
            return {
                message: '',
            }
        },
        created() {
            window.Echo.channel('store_message')
            .listen('.store_message', res => {
                this.messages.unshift(res.message)
            })
        },
        methods: {
            store() {
                var currentUrl = window.location.pathname.split('/').pop()
                axios.post(`/messages/chat`, {message: this.message, user_id: this.$page.props.auth.user.id, chat_id: currentUrl})
                .then(res => {
                    this.messages.unshift(res.data)
                    this.message = ''
                })
                .catch(error => {
                    this.errorMessage = error.message
                    console.error("There was an error!", error)
                })
            }
        }
    }

</script>

<style scoped>

</style>
