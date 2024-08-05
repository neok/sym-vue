<template>
  <div class="container mx-auto p-4">
    <BackBtn />
    <h1 class="text-4xl font-bold mb-8 text-center">Events List</h1>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
      <div v-for="event in events" :key="event.id" class="bg-white rounded-lg shadow-md p-6">
        <div class="text-center mb-4">
          <div class="text-2xl font-semibold">{{ event.name }}</div>
          <router-link
              :to="{ name: 'Tickets', params: { id: event.id } }"
              class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 text-center block"
          >
            Show Tickets
          </router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed, onMounted } from 'vue'
import { useStore } from 'vuex'
import { useRoute } from 'vue-router'
import BackBtn from "./BackBtn.vue";

const store = useStore()
const route = useRoute()
const events = computed(() => store.getters['events/events'])

onMounted(() => {
  const organizerId = route.params.id
  store.dispatch('events/fetchEvents', organizerId)
})
</script>
<script>
export default {
  name: 'Events'
}
</script>

<style scoped>
.container {
  padding: 20px;
}
</style>
