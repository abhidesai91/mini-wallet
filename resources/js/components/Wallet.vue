<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Navigation Header -->
    <nav class="bg-white shadow-sm border-b">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <h1 class="text-2xl font-bold text-gray-900">Mini Wallet</h1>
            </div>
          </div>

          <div class="flex items-center space-x-4">
            <button
              v-for="tab in tabs"
              :key="tab.id"
              @click="activeTab = tab.id"
              :class="[
                'px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200 cursor-pointer',
                activeTab === tab.id
                  ? 'bg-blue-100 text-blue-700'
                  : 'text-gray-500 hover:text-gray-700 hover:bg-gray-100'
              ]"
            >
              {{ tab.name }}
            </button>

            <button
              @click="logout"
              class="px-3 py-2 rounded-md text-sm font-medium text-white bg-red-500 hover:bg-red-600 cursor-pointer"
            >
              Logout
            </button>
          </div>
        </div>
      </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
      <!-- Dashboard Tab -->
      <div v-if="activeTab === 'dashboard'" class="space-y-6">
        <BalanceDisplay ref="balanceRef" />

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
          <TransferForm @transferred="onTransferred" />

        </div>
      </div>

      <!-- Transactions Tab -->
      <div v-if="activeTab === 'transactions'">
        <TransactionList ref="listRef" />
      </div>

    </main>
    <Notification ref="notificationRef"/>

  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import api from '../axios'
import TransferForm from './TransferForm.vue'
import TransactionList from './TransactionList.vue'
import BalanceDisplay from './BalanceDisplay.vue'
import Notification from './Notification.vue'

const router = useRouter()

const activeTab = ref('dashboard')
const notificationRef = ref(null)
const balanceRef = ref(null)
const listRef = ref(null)

const tabs = [
  { id: 'dashboard', name: 'Dashboard' },
  { id: 'transactions', name: 'Transactions' },
]

const logout = async () => {
  try {
    await api.post('/logout')
  } catch (_) {
    // ignore errors, proceed to clear session
  } finally {
    localStorage.removeItem('token')
    router.push('/login')
  }
}

const onTransferred = () => {
  balanceRef.value?.reload?.()
  listRef.value?.reload?.()
}
</script>
