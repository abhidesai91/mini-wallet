<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
      <h2 class="text-2xl font-bold mb-6 text-center">Login</h2>
      <input v-model="email" placeholder="Email" class="w-full p-3 mb-4 border rounded"/>
      <input v-model="password" type="password" placeholder="Password" class="w-full p-3 mb-4 border rounded"/>
      <button @click="login" class="w-full bg-blue-500 text-white p-3 rounded hover:bg-blue-600 cursor-pointer">Login</button>
      <p v-if="error" class="text-red-500 mt-2">{{ error }}</p>
      <div class="mt-4 text-center">
        <router-link to="/register" class="text-blue-500 hover:underline cursor-pointer">Don't have an account? Register</router-link>
      </div>
    </div>
  </div>
</template>

<script>
import api from '../axios';
export default {
  data() {
    return { email: '', password: '', error: '' }
  },
  methods: {
    async login() {
      try {
        const res = await api.post('/login', { email: this.email, password: this.password });
        localStorage.setItem('token', res.data.access_token);
        this.$router.push('/wallet');
      } catch (err) {
        this.error = err.response?.data?.message || "Login failed";
      }
    }
  }
}
</script>
