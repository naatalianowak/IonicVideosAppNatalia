<template>
  <ion-page>
    <navbar />
    <ion-content :fullscreen="true">
      <ion-header collapse="condense">
        <ion-toolbar>
          <ion-title size="large">Welcome</ion-title>
        </ion-toolbar>
      </ion-header>
      <div class="ion-padding">
        <ion-card>
          <ion-card-header>
            <ion-card-title>About VideosApp</ion-card-title>
          </ion-card-header>
          <ion-card-content>
            <p>Welcome to VideosApp, a platform where you can upload, view, and manage your videos with ease.</p>
            <p>Explore the "Videos" tab to watch content, or if you have the right permissions, head to the "Manage Videos" tab to upload and manage your videos.</p>
            <p>Created by Natalia as part of a project to learn Ionic and Laravel.</p>
          </ion-card-content>
        </ion-card>
      </div>
    </ion-content>
    <footer />
  </ion-page>
</template>

<script lang="ts">
import { IonPage, IonHeader, IonToolbar, IonTitle, IonContent, IonCard, IonCardHeader, IonCardTitle, IonCardContent } from '@ionic/vue';
import { defineComponent } from 'vue';
import Navbar from '../components/Navbar.vue';
import Footer from '../components/Footer.vue';

export default defineComponent({
  name: 'Tab1Page',
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
    Navbar,
    Footer,
  },
});
</script>

<style scoped>
.ion-padding {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100%;
}
ion-card {
  width: 100%;
  max-width: 600px;
}
</style>