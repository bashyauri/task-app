import { ref } from "vue";
import { showError, successMsg } from "../helper/toast-notification";

const loading = ref(false);
const registerInput = ref({});

async function register() {
    try {
        loading.value = true;
        const response = await axios.post(
            "https://task-app.test/api/register",
            registerInput.value
        );
        loading.value = false;
        registerInput.value = { email: "", password: "" };
        successMsg(response.data.message);
    } catch (error) {
        loading.value = false;
        if (error.response && error.response.data.errors) {
            const errors = error.response.data.errors;
            for (const key in errors) {
                if (errors.hasOwnProperty(key)) {
                    showError(errors[key][0]);
                }
            }
        } else {
            showError(error.message || "An error occurred");
        }
    }
}

export default function useRegister() {
    return { loading, registerInput, register };
}
