<template>
    <div id="app">
        <Authentication v-if="!isAuthenticated"></Authentication>
    </div>
</template>

<script>
import {mapGetters, mapState} from 'vuex';
///import HelloWorld from './components/HelloWorld.vue'
import Authentication from "./components/Authentication.vue";

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
        Authentication
    }
}
</script>

<style>
#app {
    font-family: Avenir, Helvetica, Arial, sans-serif;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    text-align: center;
    color: #2c3e50;
    margin-top: 60px;
}
</style>
