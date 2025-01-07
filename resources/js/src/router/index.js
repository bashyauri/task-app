import { createRouter, createWebHistory } from "vue-router";

const router = createRouter({
    // http://127.0.0.1:8000/app
    history: createWebHistory("/app"),
    routes: [
        {
            path: "/auth",
            name: "auth",
            component: () => import("../pages/auth/AuthPage.vue"),
            children: [
                {
                    path: "/register",
                    name: "register",
                    component: () => import("../pages/auth/RegisterPage.vue"),
                },
                {
                    path: "/login",
                    name: "login",
                    component: () => import("../pages/auth/LoginPage.vue"),
                },
            ],
        },
    ],
});

export default router;
