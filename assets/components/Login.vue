<template>
  <div class=" h-screen flex items-center justify-center">
    <div class="w-full max-w-xs">
      <Form @submit="handleLogin" :validation-schema="validationSchema"  class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <div class="mb-4">
          <label class="block text-gray-700 text-sm font-bold mb-2" for="username">
            Username
          </label>
          <Field name="email" type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
          <ErrorMessage name="email" class="error-feedback text-red-500" />
        </div>
        <div class="mb-6">
          <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
            Password
          </label>
          <Field name="password" type="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" />
          <ErrorMessage name="password" class="error-feedback text-red-500" />
        </div>
        <div class="flex items-center justify-between">
          <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
            Sign In
          </button>
          <a class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800" href="#">
            Forgot Password?
          </a>
        </div>
        <div class="form-group">
          <div v-if="message" class="text-red-500" role="alert">
            {{ message }}
          </div>
        </div>
      </Form>
      <p class="text-center text-gray-500 text-xs">
        &copy;2024 Acme Corp. All rights reserved.
      </p>
    </div>
  </div>
</template>

<script>
import { Form, Field, ErrorMessage } from "vee-validate";
import { toTypedSchema } from '@vee-validate/zod';
import * as zod from 'zod';

export default {
  name: "Login",
  components: {
    Form,
    Field,
    ErrorMessage,
  },
  data() {
    const validationSchema = toTypedSchema(
        zod.object({
          email: zod.string().email({ message: 'Must be a valid email' }),
          password: zod.string().min(8, { message: 'Too short' }),
        })
    );

    return {
      loading: false,
      message: "",
      validationSchema,
    };
  },
  computed: {
    loggedIn() {
      return this.$store.state.auth.status.loggedIn;
    },
  },
  created() {
    if (this.loggedIn) {
      this.$router.push("/dashboard");
    }
  },
  methods: {
    handleLogin(user) {
      this.loading = true;

      this.$store.dispatch("auth/login", user).then(
          () => {
            this.$router.push("/dashboard");
          },
          (error) => {
            this.loading = false;
            this.message =
                (error.response && error.response.data && error.response.data.message)
                || error.message
                || error.toString();
          }
      );
    },
  },
};
</script>
