<template>
  <div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex items-center justify-between mb-6">
      <h3 class="text-xl font-semibold text-gray-800">Transaction History</h3>
      <button class="text-blue-600 hover:text-blue-800 text-sm font-medium">
        View All
      </button>
    </div>

    <div v-if="transactions.length === 0" class="text-center py-8 text-gray-500">
      <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2v1a1 1 0 001 1h6a1 1 0 001-1V3a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
      </svg>
      <p>No transactions yet</p>
    </div>

    <div v-else class="space-y-3">
      <div
        v-for="transaction in transactions"
        :key="transaction.id"
        class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition duration-200"
      >
        <div class="flex items-center space-x-3">
          <div
            :class="[
              'w-10 h-10 rounded-full flex items-center justify-center',
              transaction.type === 'Sent' ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-600'
            ]"
          >
            <svg v-if="transaction.type === 'Sent'" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13a1 1 0 102 0V9.414l1.293 1.293a1 1 0 001.414-1.414z" clip-rule="evenodd"/>
            </svg>
            <svg v-else class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v3.586L7.707 9.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 10.586V7z" clip-rule="evenodd"/>
            </svg>
          </div>

          <div>
            <p class="font-medium text-gray-900">
              {{ transaction.type === 'Sent' ? 'Sent to' : 'Received from' }}
              User {{ transaction.userId || 'Unknown' }}
            </p>
            <p class="text-sm text-gray-500">{{ formatDate(transaction.date) }}</p>
          </div>
        </div>

        <div class="text-right">
          <p
            :class="[
              'font-semibold',
              transaction.type === 'Sent' ? 'text-red-600' : 'text-green-600'
            ]"
          >
            {{ transaction.type === 'Sent' ? '-' : '+' }}${{ transaction.amount.toFixed(2) }}
          </p>
          <p class="text-xs text-gray-400">ID: {{ transaction.id }}</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'

const transactions = ref([])

// Dummy API call
onMounted(() => {
  transactions.value = [
    { id: 1, type: 'Sent', amount: 100.00, date: '2025-09-25', userId: '123' },
    { id: 2, type: 'Received', amount: 50.00, date: '2025-09-24', userId: '456' },
    { id: 3, type: 'Sent', amount: 25.00, date: '2025-09-23', userId: '789' },
    { id: 4, type: 'Received', amount: 75.50, date: '2025-09-22', userId: '321' },
    { id: 5, type: 'Sent', amount: 200.00, date: '2025-09-21', userId: '654' },
  ]
})

const formatDate = (dateString) => {
  return new Date(dateString).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'short',
    day: 'numeric'
  })
}
</script>
