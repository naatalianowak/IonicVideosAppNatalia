<template>
  <ion-page>
    <navbar />
    <ion-content :fullscreen="true">
      <ion-header collapse="condense">
        <ion-toolbar>
          <ion-title size="large">Manage Videos</ion-title>
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
                  :accepted-file-types="['video/mp4', 'video/avi', 'video/mov']"
                  max-file-size="100MB"
                  :files="form.files"
                  @init="handleFilePondInit"
                  @addfile="handleFileAdd"
                  @error="handleFilePondError"
              />
            </div>
            <ion-button expand="block" @click="uploadVideo" :disabled="isButtonDisabled">
              <ion-spinner v-if="loading" name="crescent"></ion-spinner>
              <span v-else>Upload</span>
            </ion-button>
            <ion-text color="danger" v-if="errorMessage">
              <p>{{ errorMessage }}</p>
            </ion-text>
          </ion-card-content>
        </ion-card>
      </div>
    </ion-content>
    <footer />
  </ion-page>
</template>

<script lang="ts">
import { defineComponent, ref, computed } from 'vue';
import { IonPage, IonHeader, IonToolbar, IonTitle, IonContent, IonCard, IonCardHeader, IonCardTitle, IonCardContent, IonItem, IonLabel, IonInput, IonTextarea, IonButton, IonText, IonSpinner } from '@ionic/vue';
import { useRouter } from 'vue-router';
import apiClient from '../services/api';
import Navbar from '../components/Navbar.vue';
import Footer from '../components/Footer.vue';

// Import FilePond
import VueFilePond from 'vue-filepond';
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type';
import FilePondPluginFileValidateSize from 'filepond-plugin-file-validate-size';
import type { FilePond, FilePondErrorDescription, FilePondFile } from 'filepond';

// Create FilePond component
const FilePond = VueFilePond(FilePondPluginFileValidateType, FilePondPluginFileValidateSize);

interface FormData {
  title: string;
  description: string;
  files: File[];
}

export default defineComponent({
  name: 'Tab3Page',
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
    const pond = ref<FilePond | null>(null);
    const form = ref<FormData>({
      title: '',
      description: '',
      files: [],
    });
    const loading = ref<boolean>(false);
    const errorMessage = ref<string>('');

    const isButtonDisabled = computed(() => {
      return loading.value || !form.value.title || form.value.files.length === 0;
    });

    return {
      router,
      pond,
      form,
      loading,
      errorMessage,
      isButtonDisabled,
    };
  },
  methods: {
    handleFilePondInit() {
      console.log('FilePond has initialized');
    },
    handleFileAdd(error: FilePondErrorDescription | null, file: FilePondFile) {
      if (error) {
        console.error('FilePond add file error:', error);
        this.errorMessage = 'Error adding file: ' + error.main;
        return;
      }
      console.log('File added:', file.file.name, file.file.size, file.file.type);
      console.log('File instance:', file.file instanceof File);
      this.form.files = [file.file];
    },
    handleFilePondError(error: FilePondErrorDescription) {
      console.error('FilePond error:', error);
      this.errorMessage = 'FilePond error: ' + error.main;
    },
    async uploadVideo() {
      console.log('Starting uploadVideo...');
      console.log('Form data:', {
        title: this.form.title,
        description: this.form.description,
        filesLength: this.form.files.length,
        file: this.form.files[0] ? {
          name: this.form.files[0].name,
          size: this.form.files[0].size,
          type: this.form.files[0].type,
          instance: this.form.files[0] instanceof File,
        } : null,
      });

      if (!this.form.files.length || !(this.form.files[0] instanceof File)) {
        this.errorMessage = 'Please select a valid video file.';
        return;
      }

      this.loading = true;
      this.errorMessage = '';
      const formData = new FormData();
      formData.append('title', this.form.title);
      formData.append('description', this.form.description || '');
      formData.append('video', this.form.files[0]);
      console.log('FormData prepared for upload:', Array.from(formData.entries()));

      try {
        const response = await apiClient.post('/media', formData);
        console.log('Upload response:', response.data);
        this.form.title = '';
        this.form.description = '';
        this.form.files = [];
        if (this.pond) {
          this.pond.removeFiles();
        }
        this.router.push('/tabs/my-videos'); // Redirigir a My Videos
      } catch (error: any) {
        console.error('Upload error:', error.response?.data || error.message);
        this.errorMessage = error.response?.data?.message || 'Upload failed. Please try again.';
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