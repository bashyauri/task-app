import { ref } from "vue";

import api from "../../../../helper/makeHttpReq";
import { showError, successMsg } from "../../../../helper/toast-notification";

const loading = ref(false);
const members = ref([]);

async function getMembers(query = "") {
    try {
        loading.value = true;
        const response = await api.get("/members", {
            params: { query },
        });
        loading.value = false;
        console.log(response.data.data);

        members.value = response.data.data;

        // successMsg(response.data.message);
    } catch (error) {
        loading.value = false;
        showError(error.message || "An error occurred");
    }
}

export default function useGetMembers() {
    return { loading, members, getMembers };
}
