<template>
  <div class="bg-white rounded-lg shadow-md p-6">
    <h3 class="text-xl font-semibold text-gray-800 mb-4">Send Money</h3>

    <form @submit.prevent="submitTransfer" class="space-y-4">
      <div>
        <label for="recipient" class="block text-sm font-medium text-gray-700 mb-2">
          Recipient User ID
        </label>
        <input
          id="recipient"
          v-model="receiver_id"
          type="text"
          placeholder="Enter recipient ID"
          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
          required
        />
      </div>

      <div>
        <label for="amount" class="block text-sm font-medium text-gray-700 mb-2">
          Amount
        </label>
        <div class="relative">
          <span class="absolute left-3 top-2 text-gray-500">$</span>
          <input
            id="amount"
            v-model="amount"
            type="number"
            step="0.01"
            min="0.01"
            placeholder="0.00"
            class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
            required
          />
        </div>
      </div>

      <button
        type="submit"
        :disabled="isLoading"
        class="w-full bg-blue-600 hover:bg-blue-700 disabled:bg-blue-400 text-white font-medium py-2 px-4 rounded-md transition duration-200"
      >
        <span v-if="isLoading">Sending...</span>
        <span v-else>Send Money</span>
      </button>
    </form>

    <div v-if="message" :class="[
      'mt-4 p-3 rounded-md text-sm',
      messageType === 'success' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'
    ]">
      {{ message }}
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const receiver_id = ref('')
const amount = ref('')
const message = ref('')
const messageType = ref('success')
const isLoading = ref(false)

const submitTransfer = async () => {
  // Validation
  if (!receiver_id.value || !amount.value) {
    message.value = 'Please enter both fields'
    messageType.value = 'error'
    return
  }

  if (parseFloat(amount.value) <= 0) {
    message.value = 'Amount must be greater than 0'
    messageType.value = 'error'
    return
  }

  isLoading.value = true
  message.value = ''

  // Simulate API call
  setTimeout(() => {
    message.value = `Successfully sent $${parseFloat(amount.value).toFixed(2)} to User ${receiver_id.value}`
    messageType.value = 'success'
    receiver_id.value = ''
    amount.value = ''
    isLoading.value = false
  }, 1000)
}
</script>
