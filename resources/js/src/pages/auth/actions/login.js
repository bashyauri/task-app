import { ref } from "vue";
import api from "../../../helper/makeHttpReq";
import { showError, successMsg } from "../../../helper/toast-notification";

const loading = ref(false);
const loginInput = ref({});

async function login() {
    try {
        loading.value = true;
        const response = await api.post("/login", loginInput.value);
        loading.value = false;
        loginInput.value = { email: "", password: "" };

        successMsg(response.data.message);
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
