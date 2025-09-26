<template>
  <div class="bg-white rounded-lg shadow-md p-6">
    <h3 class="text-xl font-semibold text-gray-800 mb-4">Send Money</h3>

    <form @submit.prevent="submitTransfer" class="space-y-4">
      <!-- Recipient Autocomplete -->
      <div class="relative">
        <label for="recipient" class="block text-sm font-medium text-gray-700 mb-2">
          Recipient
        </label>
        <input
          id="recipient"
          v-model="query"
          type="text"
          placeholder="Search by name or email"
          @focus="showDropdown = true"
          @input="onQueryChange"
          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
          autocomplete="off"
          required
        />

        <!-- Suggestions -->
        <div v-if="showDropdown && filteredUsers.length"
             class="absolute z-10 mt-1 w-full bg-white border border-gray-200 rounded-md shadow-lg max-h-60 overflow-auto">
          <div v-for="u in filteredUsers" :key="u.id"
               @click="selectUser(u)"
               class="px-3 py-2 cursor-pointer hover:bg-gray-50">
            <div class="text-sm font-medium text-gray-900">{{ u.name }}</div>
            <div class="text-xs text-gray-500">{{ u.email }}</div>
          </div>
        </div>

        <p v-if="selectedUser" class="text-xs text-gray-500 mt-1">
          Selected: {{ selectedUser.name }} (ID: {{ selectedUser.id }})
        </p>
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
        :disabled="isLoading || !selectedUser"
        class="w-full bg-blue-600 hover:bg-blue-700 disabled:bg-blue-400 text-white font-medium py-2 px-4 rounded-md transition duration-200 cursor-pointer"
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
import { ref, computed, onMounted, onBeforeUnmount } from 'vue'
import api from '../axios'

const emit = defineEmits(['transferred'])

const users = ref([])
const query = ref('')
const showDropdown = ref(false)
const selectedUser = ref(null)
const amount = ref('')
const message = ref('')
const messageType = ref('success')
const isLoading = ref(false)

const fetchUsers = async (q = '') => {
  const res = await api.get('/users', { params: { per_page: 200, q } })
  users.value = res.data.data || []
}

const onClickOutside = (e) => {
  const container = e.target.closest('#recipient')
  if (!container) showDropdown.value = false
}

onMounted(() => {
  fetchUsers()
  window.addEventListener('click', onClickOutside)
})

onBeforeUnmount(() => {
  window.removeEventListener('click', onClickOutside)
})

const onQueryChange = async () => {
  showDropdown.value = true
  await fetchUsers(query.value)
}

const filteredUsers = computed(() => {
  if (!query.value) return users.value
  const q = query.value.toLowerCase()
  return users.value.filter(u =>
    (u.name && u.name.toLowerCase().includes(q)) ||
    (u.email && u.email.toLowerCase().includes(q))
  )
})

const selectUser = (u) => {
  selectedUser.value = u
  query.value = `${u.name} <${u.email}>`
  showDropdown.value = false
}

const submitTransfer = async () => {
  if (!selectedUser.value) {
    message.value = 'Please select a recipient'
    messageType.value = 'error'
    return
  }
  if (!amount.value || parseFloat(amount.value) <= 0) {
    message.value = 'Amount must be greater than 0'
    messageType.value = 'error'
    return
  }

  isLoading.value = true
  message.value = ''

  try {
    const res = await api.post('/transactions', {
      receiver_id: selectedUser.value.id,
      amount: parseFloat(amount.value)
    })

    message.value = 'Transfer successful'
    messageType.value = 'success'
    amount.value = ''
    selectedUser.value = null
    query.value = ''
    emit('transferred', res.data.transaction)
  } catch (err) {
    const apiMsg = err?.response?.data?.message
    const firstError = err?.response?.data?.errors && Object.values(err.response.data.errors)[0]?.[0]
    message.value = firstError || apiMsg || 'Transfer failed'
    messageType.value = 'error'
  } finally {
    isLoading.value = false
  }
}
</script>
