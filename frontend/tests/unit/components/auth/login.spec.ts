import { shallowMount, createLocalVue } from '@vue/test-utils'
import Vuex from 'vuex';
import Login from "@/components/auth/Login.vue";
import BootstrapVue from "bootstrap-vue";

const localVue = createLocalVue();

localVue.use(Vuex)
localVue.use(BootstrapVue);


describe("Login.vue", () => {
    let authModuleActions:any;
    let store: any;

    beforeEach(() => {
        authModuleActions = {
            loginUser: jest.fn(),
        }
        store = new Vuex.Store({
            modules: {
                authModule: {
                    actions: authModuleActions,
                    namespaced: true,
                }
            }
        })
    })

    it('вызывает действие "loginUser" при отправки формы', () => {
        const wrapper = shallowMount(Login, { store, localVue })
        let form = wrapper.find('b-form-stub')
        form.trigger('submit')
        expect(authModuleActions.loginUser).toHaveBeenCalled()
    });
});
