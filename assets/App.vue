<template>
  <div id="app">
    <nav class="bg-gray-800 p-4">
      <div class="container mx-auto flex justify-between items-center">

        <div class="flex space-x-4">
          <router-link to="/dashboard" class="text-gray-300 hover:text-white">
            Dashboard
          </router-link>

          <router-link
              v-if="currentUser"
              to="/user"
              class="text-gray-300 hover:text-white"
          >
            User
          </router-link>
        </div>
        <div class="flex space-x-4">
          <div v-if="!currentUser" class="flex space-x-4">

            <router-link to="/login" class="text-gray-300 hover:text-white">
              Login
            </router-link>
          </div>
          <div v-if="currentUser" class="flex space-x-4">
            <a
                href="#"
                @click.prevent="logOut"
                class="text-gray-300 hover:text-white"
            >
              LogOut
            </a>
          </div>
        </div>
      </div>
    </nav>

    <div class="container mx-auto mt-4">
      <router-view/>
    </div>
  </div>
</template>

<script>
export default {
  computed: {
    currentUser() {
      return this.$store.state.auth.user;
    },
  },
  methods: {
    logOut() {
      this.$store.dispatch('auth/logout');
      this.$router.push('/login');
    }
  }
};
</script>
