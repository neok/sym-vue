<template>
  <div class="container mx-auto p-4">
    <h1 class="text-4xl font-bold mb-8 text-center">Organizers List</h1>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
      <div v-for="organizer in organizers" :key="organizer.id" class="bg-white rounded-lg shadow-md p-6">
        <div class="text-center mb-4">
          <div class="text-2xl font-semibold">{{ organizer.name }}</div>
        </div>
        <router-link
            :to="{ name: 'Events', params: { id: organizer.id } }"
            class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 text-center block"
        >
          Show Events
        </router-link>
      </div>
    </div>
  </div>
</template>

<script setup>
import {computed, onMounted} from 'vue'
import {useStore} from 'vuex'

const store = useStore()
const organizers = computed(() => store.getters['organizers/organizers'])

onMounted(() => {
  store.dispatch('organizers/fetchOrganizers')
})

</script>

<style scoped>
.container {
  padding: 20px;
}
</style>
