<template>
    <div>
        <b-form
            @submit="onSubmit" @reset="onReset">
            <b-form-group
                id="input-group-1"
                label-for="input-1"
                description="Email"
            >
                <b-form-input
                    id="input-1"
                    v-model="form.email"
                    type="email"
                    placeholder="Enter email"
                    required
                ></b-form-input>
            </b-form-group>

            <b-form-group
                id="input-group-2"
                description="password"
                label-for="input-2"
            >
                <b-form-input
                    id="input-2"
                    type="password"
                    v-model="form.password"
                    placeholder="Enter password"
                    required
                ></b-form-input>
            </b-form-group>

            <b-form-group>
                <b-form-checkbox
                    v-model="form.isRemember"
                    value="true">isRemember</b-form-checkbox>
            </b-form-group>

            <b-button type="submit" variant="primary">LogIn</b-button>
<!--            <b-button type="reset" variant="danger">Reset</b-button>-->
        </b-form>
    </div>
</template>

<script lang="ts">
import {Component, Vue} from "vue-property-decorator";
import {authInterface} from "@/store/modules/auth/Interface";
import {namespace} from 'vuex-class'
import authModule from "@/store/modules/auth/authModule";

const someAuthModule = namespace('authModule');


@Component
export default class Login extends Vue {
    // Авторизация пользователя
    @someAuthModule.Action('loginUser') loginUser!: (form: authInterface) => void


    public form: authInterface = {
        email: '',
        password: '',
        isRemember: true,
    };

    public onSubmit(event: Event) {
        event.preventDefault();
        this.loginUser(this.form);
    }

    public onReset(event: Event) {
        event.preventDefault();
        // Reset our form values
        this.form.email = '';
        this.form.password = '';
    }
}
</script>

<style scoped>

</style>
