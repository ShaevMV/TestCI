<template>
  <div id="app">
    <Login v-if="!isLogin"/>
    <router-view v-else />
  </div>
</template>

<script lang="ts">
import { Component, Vue } from "vue-property-decorator";
import Login from "@/components/auth/Login.vue";
import {namespace} from "vuex-class"; // @ is an alias to /src

const someAuthModule = namespace('authModule');

@Component({
  components: {
    Login
  }
})
export default class AppView extends Vue {
  // вывести ошибки авторизации
  @someAuthModule.Getter('isLogin') isLogin!: () => boolean;
}
</script>
