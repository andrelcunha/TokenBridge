<template>
  <q-page>
    <div class="q-pa-md">
      <q-card>
        <q-card-section>
          <q-input v-model="name" label="Name" />
          <q-input v-model="email" label="Email" />
          <q-input v-model="password" label="Password" type="password" />
        </q-card-section>
        <q-card-actions>
          <q-btn @click="register" label="Register" color="primary" />
        </q-card-actions>
      </q-card>
    </div>
  </q-page>
</template>

<script>
import { ref } from 'vue';
import axios from 'axios';

export default {
  name: 'RegistrationPage',
  setup() {
    const name = ref('');
    const email = ref('');
    const password = ref('');

    const register = async () => {
      try {
        const response = await axios.post('http://localhost:8001/api/register', {
          name: name.value,
          email: email.value,
          password: password.value,
        });
        console.log('Registration successful:', response.data);
      } catch (error) {
        console.error('Registration failed:', error);
      }
    };

    return { name, email, password, register };
  },
};
</script>
