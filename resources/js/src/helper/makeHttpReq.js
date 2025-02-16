import axios from "axios";

const api = axios.create({
    baseURL: "https://task-app.test/api", // Replace with your API base URL
    headers: {
        "Content-Type": "application/json",
    },
});
api.interceptors.request.use(
    (config) => {
        const token = localStorage.getItem("auth_token");
        if (token) {
            config.headers.Authorization = `Bearer ${token}`;
        }
        return config;
    },
    (error) => Promise.reject(error)
);

export default api;
