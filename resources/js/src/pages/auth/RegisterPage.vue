<!-- filepath: /c:/laragon/www/task-app/resources/js/src/pages/auth/RegisterPage.vue -->
<template>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-4 col-lg-6">
        <div class="card shadow-lg">
          <div class="card-header bg-primary text-white">
            <h3 class="text-center mb-0">Register</h3>
          </div>
          <div class="card-body p-4">
            <form @submit.prevent="register">
              
              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" v-model="email" required>
              </div>
              <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" v-model="password" required>
              </div>
              <button type="submit" class="btn btn-primary w-100">Register</button>
            </form>
          </div>
          <div class="card-footer text-center">
            <small class="text-muted">Already have an account? <a href="/auth/login" class="text-primary">Login</a></small>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';

const name = ref('');
const email = ref('');
const password = ref('');

const register = () => {
  // Handle registration logic here
  console.log('Registering:', { name: name.value, email: email.value, password: password.value });
};
</script>

<style>
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