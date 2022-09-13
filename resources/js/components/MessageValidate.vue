<template>
    <div class="form-validate-messages message message-error" v-if="messages">
        <p class="message-item" v-for="(message, index) in messages" :key="index">{{ message }}</p>
    </div>
</template>
<script>
    export default {
        props: [
            'messages',
        ]
    }
</script>