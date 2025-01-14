import axios from "axios";

const api = axios.create({
    baseURL: "https://task-app.test/api", // Replace with your API base URL
    headers: {
        "Content-Type": "application/json",
    },
});

export default api;
