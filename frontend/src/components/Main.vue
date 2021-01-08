<template>
    <div v-bind:class="getStyleForMain">
        <!--  BEGIN NAVBAR  -->
            <Navbar></Navbar>
        <!--  END NAVBAR  -->

        <!--  BEGIN MAIN CONTAINER  -->
        <div v-bind:class="getStyleForMainSideBar" id="container">

            <div class="overlay show"></div>
            <div class="cs-overlay"></div>
            <div class="search-overlay"></div>

            <!--  BEGIN SIDEBAR  -->
                <Sidebar></Sidebar>
            <!--  END SIDEBAR  -->

            <!--  BEGIN CONTENT AREA  -->
            <div id="content" class="main-content">
                <div class="layout-px-spacing">
                    <div class="row layout-top-spacing">
                        <router-view></router-view>
                    </div>
                </div>
            </div>
            <!--  END CONTENT AREA  -->

        </div>
        <!-- END MAIN CONTAINER -->
    </div>
</template>

<script>
import Navbar from "./bar/Navbar";
import Sidebar from "./bar/Sidebar";
import { mapGetters} from 'vuex';
export default {
    name: "Main",
    components: {Sidebar, Navbar},
    computed: {
        ...mapGetters('appStyle',[
            'getStyleForMainSideBar',
            'getStyleForMain',
        ])
    }
}
</script>

<style scoped>
    .alt-menu {
        color: #888ea8;
        height: 100%;
        font-size: 0.875rem;
        background: #060818;
        overflow-x: hidden;
        overflow-y: auto;
        letter-spacing: 0.0312rem;
        font-family: 'Nunito', sans-serif;
    }
</style>

<style href="../../public/plugins/apex/apexcharts.css"></style>
<style href="../assets/css/dashboard/dash_1.css"></style>
