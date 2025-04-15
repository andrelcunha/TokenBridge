
<template>
  <q-page>
    <div class="q-pa-md">
      <q-card>
        <q-card-section>
          <q-input v-model="email" label="Email" />
          <q-input v-model="password" label="Password" type="password" />
        </q-card-section>
        <q-card-actions>
          <q-btn @click="login" label="Login" color="primary" />
        </q-card-actions>
      </q-card>
      <div class="q-my-md">
        <q-btn flat label="Don't have an account yet? Sign up now!" @click="goToRegister" />
      </div>
    </div>
  </q-page>
</template>

<script>

import axios from 'axios';
export default {
  name: 'LoginPage',
  data() {
    return {
      email: '',
      password: '',
    };
  },
  methods: {
    async login() {
      try {
        const response = await axios.post('http://localhost:8001/api/login', {
          email: this.email,
          password: this.password,
        });
        document.cookie = `token=${response.data.token};`;
        this.$router.push('/tasks');
      } catch (error) {
        console.error('Login failed:', error);
      }
    },
    goToRegister() {
      this.$router.push('/register');
    },
  },
};
</script>
