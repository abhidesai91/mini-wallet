<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
      <h2 class="text-2xl font-bold mb-6 text-center">Register</h2>
      <input v-model="name" placeholder="Name" class="w-full p-3 mb-4 border rounded"/>
      <input v-model="email" placeholder="Email" class="w-full p-3 mb-4 border rounded"/>
      <input v-model="password" type="password" placeholder="Password" class="w-full p-3 mb-4 border rounded"/>
      <input v-model="password_confirmation" type="password" placeholder="Confirm Password" class="w-full p-3 mb-4 border rounded"/>
      <button @click="register" class="w-full bg-green-500 text-white p-3 rounded hover:bg-green-600">Register</button>
      <p v-if="error" class="text-red-500 mt-2">{{ error }}</p>
      <div class="mt-4 text-center">
        <router-link to="/login" class="text-blue-500 hover:underline">Already have an account? Login</router-link>
      </div>
    </div>
  </div>
</template>

<script>
import api from '../axios';
export default {
  data() {
    return { name: '', email: '', password: '', password_confirmation: '', error: '' }
  },
  methods: {
    async register() {
      try {
        const res = await api.post('/register', {
          name: this.name,
          email: this.email,
          password: this.password,
          password_confirmation: this.password_confirmation
        });
        localStorage.setItem('token', res.data.access_token);
        this.$router.push('/dashboard');
      } catch (err) {
        this.error = err.response?.data?.message || "Registration failed";
      }
    }
  }
}
</script>
