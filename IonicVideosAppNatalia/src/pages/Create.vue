<template>
  <ion-page>
    <navbar />
    <ion-content :fullscreen="true">
      <ion-header collapse="condense">
        <ion-toolbar>
          <ion-title size="large">Upload Video</ion-title>
        </ion-toolbar>
      </ion-header>
      <div class="ion-padding">
        <ion-card>
          <ion-card-header>
            <ion-card-title>Upload a New Video</ion-card-title>
          </ion-card-header>
          <ion-card-content>
            <ion-item>
              <ion-label position="floating">Title</ion-label>
              <ion-input v-model="form.title" type="text" required></ion-input>
            </ion-item>
            <ion-item>
              <ion-label position="floating">Description</ion-label>
              <ion-textarea v-model="form.description" rows="3"></ion-textarea>
            </ion-item>
            <div class="filepond-wrapper">
              <file-pond
                name="video"
                ref="pond"
                label-idle="Drop your video here or <span class='filepond--label-action'>Browse</span>"
                accepted-file-types="video/mp4,video/avi,video/mov"
                max-file-size="100MB"
                v-bind:files="form.files"
                @init="handleFilePondInit"
                @addfile="handleFileAdd"
              />
            </div>
            <ion-button expand="block" @click="uploadVideo" :disabled="loading || !form.title || !form.files.length">
              <ion-spinner v-if="loading" name="crescent"></ion-spinner>
              <span v-else>Upload</span>
            </ion-button>
            <ion-text color="danger" v-if="error">
              <p>{{ error }}</p>
            </ion-text>
          </ion-card-content>
        </ion-card>
      </div>
    </ion-content>
    <footer />
  </ion-page>
</template>

<script lang="ts">
import { IonPage, IonHeader, IonToolbar, IonTitle, IonContent, IonCard, IonCardHeader, IonCardTitle, IonCardContent, IonItem, IonLabel, IonInput, IonTextarea, IonButton, IonText, IonSpinner } from '@ionic/vue';
import { defineComponent } from 'vue';
import { useRouter } from 'vue-router';
import apiClient from '../services/api';
import Navbar from '../components/Navbar.vue';
import Footer from '../components/Footer.vue';

// Import FilePond
import VueFilePond from 'vue-filepond';
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type';
import FilePondPluginFileValidateSize from 'filepond-plugin-file-validate-size';

// Create FilePond component
const FilePond = VueFilePond(FilePondPluginFileValidateType, FilePondPluginFileValidateSize);

export default defineComponent({
  name: 'CreatePage',
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
    IonItem,
    IonLabel,
    IonInput,
    IonTextarea,
    IonButton,
    IonText,
    IonSpinner,
    Navbar,
    Footer,
    FilePond,
  },
  setup() {
    const router = useRouter();
    return { router };
  },
  data() {
    return {
      form: {
        title: '',
        description: '',
        files: [],
      },
      loading: false,
      error: '',
    };
  },
  methods: {
    handleFilePondInit() {
      console.log('FilePond has initialized');
    },
    handleFileAdd(error: any, file: any) {
      if (error) {
        this.error = 'Error adding file: ' + error;
        return;
      }
      this.form.files = [file.file];
    },
    async uploadVideo() {
      this.loading = true;
      this.error = '';
      const formData = new FormData();
      formData.append('title', this.form.title);
      formData.append('description', this.form.description);
      formData.append('video', this.form.files[0]);

      try {
        await apiClient.post('/media', formData, {
          headers: {
            'Content-Type': 'multipart/form-data',
          },
        });
        this.router.push('/tabs/home');
      } catch (error: any) {
        this.error = error.response?.data?.message || 'Upload failed. Please try again.';
      } finally {
        this.loading = false;
      }
    },
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
  max-width: 400px;
}
ion-button {
  margin-top: 20px;
}
.filepond-wrapper {
  margin-top: 20px;
}
</style>