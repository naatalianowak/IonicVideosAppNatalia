<template>
  <ion-page>
    <ion-content class="ion-padding">
      <div class="login-container">
        <ion-card>
          <ion-card-header>
            <ion-card-title>Login</ion-card-title>
          </ion-card-header>
          <ion-card-content>
            <ion-item>
              <ion-label position="floating">Email</ion-label>
              <ion-input v-model="form.email" type="email" required></ion-input>
            </ion-item>
            <ion-item>
              <ion-label position="floating">Password</ion-label>
              <ion-input v-model="form.password" type="password" required></ion-input>
            </ion-item>
            <ion-button expand="block" @click="login" :disabled="loading">
              <ion-spinner v-if="loading" name="crescent"></ion-spinner>
              <span v-else>Login</span>
            </ion-button>
            <ion-text color="danger" v-if="error">
              <p>{{ error }}</p>
            </ion-text>
            <p class="register-link">
              Don't have an account? <a href="/register">Register</a>
            </p>
          </ion-card-content>
        </ion-card>
      </div>
    </ion-content>
  </ion-page>
</template>

<script lang="ts">
import { IonPage, IonContent, IonCard, IonCardHeader, IonCardTitle, IonCardContent, IonItem, IonLabel, IonInput, IonButton, IonText, IonSpinner } from '@ionic/vue';
import { defineComponent } from 'vue';
import { useRouter } from 'vue-router';
import apiClient from '../services/api';

export default defineComponent({
  name: 'LoginPage',
  components: {
    IonPage,
    IonContent,
    IonCard,
    IonCardHeader,
    IonCardTitle,
    IonCardContent,
    IonItem,
    IonLabel,
    IonInput,
    IonButton,
    IonText,
    IonSpinner,
  },
  setup() {
    const router = useRouter();
    return { router };
  },
  data() {
    return {
      form: {
        email: '',
        password: '',
      },
      loading: false,
      error: '',
    };
  },
  methods: {
    async login() {
      this.loading = true;
      this.error = '';
      try {
        const response = await apiClient.post('/login', {
          email: this.form.email,
          password: this.form.password,
        });
        console.log('Login response:', response.data);
        const roles = response.data.user.roles || [];
        console.log('Roles to store:', roles);
        localStorage.setItem('token', response.data.token);
        localStorage.setItem('roles', JSON.stringify(roles));
        console.log('Roles stored in localStorage:', localStorage.getItem('roles'));
        this.router.push('/tabs/videos');
      } catch (error: any) {
        this.error = error.response?.data?.message || 'Login failed. Please try again.';
      } finally {
        this.loading = false;
      }
    },
  },
});
</script>

<style scoped>
.login-container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100%;
}
ion-card {
  width: 100%;
  max-width: 400px;
}
ion-button {
  margin-top: 20px;
}
.register-link {
  margin-top: 20px;
  text-align: center;
}
</style>