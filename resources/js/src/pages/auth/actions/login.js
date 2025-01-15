import { reactive, ref } from "vue";
import api from "../../../helper/makeHttpReq";
import { showError, successMsg } from "../../../helper/toast-notification";

const loading = ref(false);
const loginInput = ref({});
const loginResponse = reactive({
    user: {},
    isLoggedIn: false,
    token: null,
    errors: [],
});

async function login() {
    try {
        loading.value = true;
        const response = await api.post("/login", loginInput.value);
        loading.value = false;
        loginInput.value = { email: "", password: "" };

        const { isLoggedIn } = response.data.data;

        successMsg(response.data.message);
        if (isLoggedIn) {
            localStorage.setItem(
                "userData",
                JSON.stringify(response.data.data)
            );
            window.location.href = "app/dashboard";
        }
    } catch (error) {
        loading.value = false;
        if (error.response.data.errors) {
            const errors = error.response.data.errors;
            for (const key in errors) {
                if (errors.hasOwnProperty(key)) {
                    showError(errors[key][0]);
                }
            }
        } else {
            showError(error.response.data.message || "An error occurred");
        }
    }
}

export default function useLogin() {
    return { loading, loginInput, login };
}
