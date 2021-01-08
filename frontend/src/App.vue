<template>
    <div id="app">
        <Authentication v-if="!isAuthenticated"></Authentication>
        <Main v-else></Main>
    </div>
</template>

<script>
import {mapGetters, mapState} from 'vuex';
import Authentication from "./components/auth/Authentication.vue";
import Main from "./components/Main";

export default {
    name: 'App',
    computed: {
        ...mapState([
            'token'
        ]),
        ...mapGetters([
            'isAuthenticated'
        ])
    },
    components: {
        Main,
        Authentication
    }
}
</script>

<style>
</style>
