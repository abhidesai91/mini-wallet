<template>
  <div
    v-if="notification.show"
    :class="[
      'fixed top-4 right-4 p-4 rounded-lg shadow-lg transition-all duration-300 z-50 max-w-sm',
      notification.type === 'success' ? 'bg-green-500 text-white' :
      notification.type === 'error' ? 'bg-red-500 text-white' :
      notification.type === 'warning' ? 'bg-yellow-500 text-white' :
      'bg-blue-500 text-white'
    ]"
  >
    <div class="flex items-center space-x-2">
      <!-- Success Icon -->
      <svg v-if="notification.type === 'success'" class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
      </svg>

      <!-- Error Icon -->
      <svg v-else-if="notification.type === 'error'" class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
      </svg>

      <!-- Warning Icon -->
      <svg v-else-if="notification.type === 'warning'" class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
      </svg>

      <!-- Info Icon -->
      <svg v-else class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
      </svg>

      <span class="flex-1">{{ notification.message }}</span>

      <!-- Close Button -->
      <button @click="hideNotification" class="ml-2 flex-shrink-0">
        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
        </svg>
      </button>
    </div>
  </div>
</template>

<script setup>
import { reactive } from 'vue'

const notification = reactive({
  show: false,
  type: 'info', // success, error, warning, info
  message: ''
})

let timeoutId = null

const showNotification = (type, message, duration = 5000) => {
  notification.show = true
  notification.type = type
  notification.message = message

  // Clear existing timeout
  if (timeoutId) {
    clearTimeout(timeoutId)
  }

  // Auto hide after duration
  timeoutId = setTimeout(() => {
    hideNotification()
  }, duration)
}

const hideNotification = () => {
  notification.show = false
  if (timeoutId) {
    clearTimeout(timeoutId)
    timeoutId = null
  }
}

// Expose functions for parent components
defineExpose({
  showNotification,
  hideNotification
})

// Demo notification (remove this in production)
setTimeout(() => {
  showNotification('info', 'Welcome to Mini Wallet! 🎉')
}, 2000)
</script>
