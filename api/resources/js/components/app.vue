<template>
    <div>
        {{ message }}
    </div>
</template>
<script>
export default {
    computed: {},
    created() {
        console.log(process.env.MIX_PUSHER_APP_KEY_API);
    },
    data() {
        return {
            message: 'Hello World'
        }
    }
};
</script>
