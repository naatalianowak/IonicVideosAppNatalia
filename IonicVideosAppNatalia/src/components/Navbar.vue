<template>
  <ion-header>
    <ion-toolbar>
      <ion-buttons slot="start">
        <ion-button router-link="/tabs/home">Home</ion-button>
      </ion-buttons>
      <ion-buttons slot="end">
        <ion-button v-if="isLoggedIn" @click="logout">Logout</ion-button>
        <ion-button v-else router-link="/login">Login</ion-button>
      </ion-buttons>
    </ion-toolbar>
  </ion-header>
</template>

<script lang="ts">
import { IonHeader, IonToolbar, IonTitle, IonButtons, IonButton } from '@ionic/vue';
import { defineComponent } from 'vue';
import { useRouter } from 'vue-router';
import apiClient from '../services/api';

export default defineComponent({
  name: 'Navbar',
  components: {
    IonHeader,
    IonToolbar,
    IonTitle,
    IonButtons,
    IonButton,
  },
  setup() {
    const router = useRouter();
    return { router };
  },
  computed: {
    isLoggedIn() {
      return !!localStorage.getItem('token');
    },
    canManageVideos() {
      const roles = JSON.parse(localStorage.getItem('roles') || '[]');
      const requiredRoles = ['Video Manager', 'Super Admin'];
      return roles.some((role: string) => requiredRoles.includes(role));
    },
  },
  methods: {
    async logout() {
      try {
        await apiClient.post('/logout', {});
      } catch (error) {
        console.error('Error during logout:', error);
      } finally {
        localStorage.removeItem('token');
        localStorage.removeItem('roles');
        this.router.push('/login');
      }
    },
  },
});
</script>