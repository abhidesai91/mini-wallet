<template>
  <div class="bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg p-6 text-white">
    <div class="flex items-center justify-between">
      <div>
        <h2 class="text-lg font-medium opacity-90">Current Balance</h2>
        <p class="text-3xl font-bold mt-2">${{ balance.toFixed(2) }}</p>
        <p class="text-sm opacity-75 mt-1">Available to spend</p>
      </div>
      <div class="bg-white bg-opacity-20 rounded-full p-3">
        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
          <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4zM18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z"/>
        </svg>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'

const balance = ref(0)

// Dummy API call
onMounted(() => {
  balance.value = 500.00 // initial dummy balance
})
</script>
