<template>
  <div class="container mx-auto p-4">
    <BackBtn />
    <h1 class="text-4xl font-bold mb-8 text-center">Tickets List</h1>

    <div class="">
      <router-link :to="{ name: 'CreateTicket', params: { eventId: eventId } }" class="bg-green-500 text-white py-2 px-4 rounded-lg hover:bg-green-600 ">Create New Ticket</router-link>

      <table class="min-w-full bg-white mt-6">
        <thead class="bg-gray-800 text-white">
        <tr>
          <th class="w-1/5 py-3 px-4 uppercase font-semibold text-sm">ID</th>
          <th class="w-1/5 py-3 px-4 uppercase font-semibold text-sm">Name</th>
          <th class="w-1/5 py-3 px-4 uppercase font-semibold text-sm">Price</th>
          <th class="w-1/5 py-3 px-4 uppercase font-semibold text-sm">Quantity</th>
          <th class="w-1/5 py-3 px-4 uppercase font-semibold text-sm">Actions</th>
        </tr>
        </thead>
        <tbody class="text-gray-700">
        <tr v-for="ticket in tickets" :key="ticket.id">
          <td class="w-1/5 py-3 px-4">{{ ticket.id }}</td>
          <td class="w-1/5 py-3 px-4">{{ ticket.name }}</td>
          <td class="w-1/5 py-3 px-4">{{ ticket.price }}</td>
          <td class="w-1/5 py-3 px-4">{{ ticket.quantity }}</td>
          <td class="w-1/5 py-3 px-4 flex space-x-2">
            <router-link :to="{ name: 'EditTicket', params: { eventId: eventId, id: ticket.id } }" class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600">Edit</router-link>
          </td>
        </tr>
        </tbody>
      </table>

    </div>

  </div>
</template>

<script setup>
import { computed, onMounted } from 'vue'
import { useStore } from 'vuex'
import { useRoute } from 'vue-router'
import BackBtn from "../BackBtn.vue";

const store = useStore()
const route = useRoute()
const eventId = route.params.id
const tickets = computed(() => store.getters['tickets/tickets'])

onMounted(() => {
  store.dispatch('tickets/fetchTickets', eventId)
})
</script>

<style scoped>
.container {
  padding: 20px;
}
</style>
