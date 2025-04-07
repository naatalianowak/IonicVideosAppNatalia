<template>
  <ion-page>
    <navbar />
    <ion-content :fullscreen="true">
      <ion-header collapse="condense">
        <ion-toolbar>
          <ion-title size="large">Videos</ion-title>
        </ion-toolbar>
      </ion-header>
      <div class="ion-padding">
        <ion-card v-for="video in videos" :key="video.id">
          <ion-card-header>
            <ion-card-title>{{ video.title }}</ion-card-title>
          </ion-card-header>
          <ion-card-content>
            <p>{{ video.description }}</p>
            <video controls :src="video.url" style="width: 100%; max-height: 300px;"></video>
          </ion-card-content>
        </ion-card>
        <ion-text color="danger" v-if="error">
          <p>{{ error }}</p>
        </ion-text>
        <ion-text v-if="!videos.length && !error">
          <p>No videos available.</p>
        </ion-text>
      </div>
    </ion-content>
    <footer />
  </ion-page>
</template>

<script lang="ts">
import { IonPage, IonHeader, IonToolbar, IonTitle, IonContent, IonCard, IonCardHeader, IonCardTitle, IonCardContent, IonText } from '@ionic/vue';
import { defineComponent } from 'vue';
import apiClient from '../services/api';
import Navbar from '../components/Navbar.vue';
import Footer from '../components/Footer.vue';

export default defineComponent({
  name: 'Tab2Page',
  components: {
    IonPage,
    IonHeader,
    IonToolbar,
    IonTitle,
    IonContent,
    IonCard,
    IonCardHeader,
    IonCardTitle,
    IonCardContent,
    IonText,
    Navbar,
    Footer,
  },
  data() {
    return {
      videos: [],
      error: '',
    };
  },
  async mounted() {
    await this.fetchVideos();
  },
  methods: {
    async fetchVideos() {
      this.error = '';
      try {
        const response = await apiClient.get('/media');
        this.videos = response.data;
      } catch (error: any) {
        this.error = error.response?.data?.message || 'Failed to load videos. Please try again.';
      }
    },
  },
});
</script>

<style scoped>
.ion-padding {
  display: flex;
  flex-direction: column;
  gap: 16px;
}
ion-card {
  width: 100%;
  max-width: 600px;
  margin: 0 auto;
}
</style>