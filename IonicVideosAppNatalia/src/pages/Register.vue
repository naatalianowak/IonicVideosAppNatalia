<template>
  <ion-page>
    <ion-content class="ion-padding">
      <div class="register-container">
        <ion-card>
          <ion-card-header>
            <ion-card-title>Register</ion-card-title>
          </ion-card-header>
          <ion-card-content>
            <ion-item>
              <ion-label position="floating">Name</ion-label>
              <ion-input v-model="form.name" type="text" required></ion-input>
            </ion-item>
            <ion-item>
              <ion-label position="floating">Email</ion-label>
              <ion-input v-model="form.email" type="email" required></ion-input>
            </ion-item>
            <ion-item>
              <ion-label position="floating">Password</ion-label>
              <ion-input v-model="form.password" type="password" required></ion-input>
            </ion-item>
            <ion-button expand="block" @click="register" :disabled="loading">
              <ion-spinner v-if="loading" name="crescent"></ion-spinner>
              <span v-else>Register</span>
            </ion-button>
            <ion-text color="danger" v-if="error">
              <p>{{ error }}</p>
            </ion-text>
            <p class="login-link">
              Already have an account? <a href="/login">Login</a>
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
  name: 'RegisterPage',
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
        name: '',
        email: '',
        password: '',
      },
      loading: false,
      error: '',
    };
  },
  methods: {
    async register() {
      this.loading = true;
      this.error = '';
      try {
        const response = await apiClient.post('/register', {
          name: this.form.name,
          email: this.form.email,
          password: this.form.password,
        });
        localStorage.setItem('token', response.data.token);
        localStorage.setItem('roles', JSON.stringify(response.data.user.roles || []));
        this.router.push('/tabs/videos');
      } catch (error: any) {
        this.error = error.response?.data?.message || 'Registration failed. Please try again.';
      } finally {
        this.loading = false;
      }
    },
  },
});
</script>

<style scoped>
.register-container {
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
.login-link {
  margin-top: 20px;
  text-align: center;
}
</style>