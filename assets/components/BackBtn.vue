<template>
  <button
      @click="goBack"
      class="bg-gray-800 text-white text-sm py-1 px-2 rounded-md hover:bg-gray-700"
  >
    Go Back
  </button>
</template>

<script setup>
import { useRouter } from 'vue-router'

const router = useRouter()

const goBack = () => {
  router.back()
}
</script>

<style scoped>
button {
  cursor: pointer;
}
</style>
