import { ref } from "vue";
import { makeHttpReq } from "../helper/makeHttpReq";
import { showError, successMsg } from "../helper/toast-notification";

const loading = ref(false);
const registerInput = ref({});

async function register() {
    try {
        loading.value = true;
        const data = await makeHttpReq("register", "POST", registerInput.value);
        loading.value = false;
        registerInput.value = {};
        successMsg(data.message);
    } catch (error) {
        loading.value = false;
        if (Array.isArray(error)) {
            for (const message of error) {
                showError(message);
            }
        } else {
            showError(error.message || "An error occurred");
        }
    }
}

export default function useRegister() {
    return { register, loading };
}
