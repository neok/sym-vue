<template>
  <div class="container mx-auto p-4">
    <h1 class="text-4xl font-bold mb-8 text-center">Create New Ticket</h1>
    <form @submit.prevent="onSubmit" class="max-w-md mx-auto">
      <div class="mb-4">
        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
        <input
            v-model="form.name"
            type="text"
            id="name"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
        />
      </div>
      <div class="mb-4">
        <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
        <input
            v-model.number="form.price"
            type="number"
            id="price"
            step="0.01"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
        />
      </div>
      <div class="mb-4">
        <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity</label>
        <input
            v-model.number="form.quantity"
            type="number"
            id="quantity"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
        />
      </div>
      <button type="submit" class="bg-green-500 text-white py-2 px-4 rounded-lg hover:bg-green-600">Create Ticket</button>
    </form>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useStore } from 'vuex'
import { useRoute, useRouter } from 'vue-router'

const store = useStore()
const route = useRoute()
const router = useRouter()

const form = ref({
  name: '',
  price: 0,
  quantity: 1
})

const onSubmit = async () => {
  try {
    const newTicket = await store.dispatch('tickets/createTicket', {
      ...form.value,
      event: route.params.eventId
    })
    console.log('New ticket created:', newTicket)
    router.push({ name: 'Tickets', params: { id: route.params.eventId } })
  } catch (error) {
    console.error('Error creating ticket:', error)
  }
}
</script>

<style scoped>
.container {
  padding: 20px;
}
</style>
