<script setup>
import useLogin from "./actions/login";
import { useVuelidate } from "@vuelidate/core";
import { required, email } from "@vuelidate/validators";
import Error from "../../components/Error.vue";
import BaseInput from "../../components/BaseInput.vue";
import BaseBtn from "../../components/BaseBtn.vue";

const rules = {
    email: { required, email }, // Matches state.contact.email
    password: { required, minLength: 8 }, // Matches state.contact.password
};
const { loading, login, loginInput } = useLogin();
const v$ = useVuelidate(rules, loginInput);

async function submitLogin() {
    const result = v$.value.$validate();
    if (result) {
        await login(loginInput);
        v$.value.$reset();
    }
}
</script>
<template>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-4 col-lg-6">
                <div class="card shadow-lg">
                    <div class="card-header bg-primary text-white">
                        <h3 class="text-center mb-0">Login</h3>
                    </div>
                    <div class="card-body p-4">
                        <form @submit.prevent="submitLogin">
                            <div class="mb-3">
                                <Error label="Email" :errors="v$.email.$errors">
                                    <BaseInput v-model="loginInput.email" />
                                </Error>
                            </div>
                            <div class="mb-3">
                                <Error
                                    label="Password"
                                    :errors="v$.email.$errors"
                                >
                                    <BaseInput
                                        v-model="loginInput.password"
                                        inputType="password"
                                    />
                                </Error>
                            </div>
                            <div class="mb-3">
                                <BaseBtn label="Submit" :loading="loading" />
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        <small class="text-muted">
                            Don't have an account?
                            <router-link to="/register">Register</router-link>
                            <!-- <RouterLink
                                to="/register"
                                class="text-primary btn-link"
                            >
                                Login
                            </RouterLink> -->
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
/* Add any custom styles here */
body {
    background-color: #f8f9fa;
}

.card {
    border-radius: 10px;
}

.card-header {
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
}

.card-footer {
    border-bottom-left-radius: 10px;
    border-bottom-right-radius: 10px;
}
</style>
