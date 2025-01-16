import { createRouter, createWebHistory } from "vue-router";

// Lazy load components for better readability
const AuthPage = () => import("../pages/auth/AuthPage.vue");
const RegisterPage = () => import("../pages/auth/RegisterPage.vue");
const LoginPage = () => import("../pages/auth/LoginPage.vue");
const AdminPage = () => import("../pages/admin/AdminPage.vue");
const DashboardPage = () =>
    import("../pages/admin/dashboard/DashboardPage.vue");
const MemberPage = () => import("../pages/admin/member/MemberPage.vue");
const CreateMember = () => import("../pages/admin/member/CreateMember.vue");
// const ProjectPage = () => import("../pages/admin/project/ProjectPage.vue");
// const KabanBoard = () => import("../pages/admin/kabanboard/KabanBoard.vue");

const router = createRouter({
    history: createWebHistory("/app"),
    routes: [
        {
            path: "/register",
            component: AuthPage,
            children: [
                {
                    path: "", // Default child route for /register
                    name: "register",
                    component: RegisterPage,
                },
                {
                    path: "/login",
                    name: "login",
                    component: LoginPage,
                },
            ],
        },
        {
            path: "/admin",
            component: AdminPage,
            children: [
                {
                    path: "/dashboard",
                    name: "/dashboard", // Updated name for clarity
                    component: DashboardPage,
                },
                {
                    path: "/members",
                    name: "members",
                    component: MemberPage,
                },
                {
                    path: "/create-members",
                    name: "create-members",
                    component: CreateMember,
                },
                // {
                //     path: "projects",
                //     name: "projects",
                //     component: ProjectPage,
                // },
                // {
                //     path: "kaban",
                //     name: "kaban",
                //     component: KabanBoard,
                // },
            ],
        },
    ],
});

export default router;
