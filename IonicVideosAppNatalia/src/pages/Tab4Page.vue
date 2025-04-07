<template>
  <ion-page>
    <navbar />
    <ion-content :fullscreen="true">
      <ion-header collapse="condense">
        <ion-toolbar>
          <ion-title size="large">My Videos</ion-title>
        </ion-toolbar>
      </ion-header>
      <div class="ion-padding">

        <!-- Llista de vídeos -->
        <ion-button expand="block" @click="fetchVideos" :disabled="loading">
          <ion-spinner v-if="loading" name="crescent"></ion-spinner>
          <span v-else>Refresh</span>
        </ion-button>
        <ion-list v-if="videos.length > 0">
          <ion-item v-for="video in videos" :key="video.id">
            <ion-label>{{ video.title }}</ion-label>
            <ion-button slot="end" @click="playVideo(video.file_path)">Play</ion-button>
            <ion-button slot="end" @click="openEditModal(video)">Edit</ion-button>
            <ion-button slot="end" color="danger" @click="deleteVideo(video.id)">Delete</ion-button>
          </ion-item>
        </ion-list>
        <ion-text v-else>
          <p>No videos found.</p>
        </ion-text>
        <ion-text color="danger" v-if="errorMessage">
          <p>{{ errorMessage }}</p>
        </ion-text>
      </div>

      <!-- Modal per editar un vídeo -->
      <ion-modal :is-open="isEditModalOpen" @didDismiss="closeEditModal">
        <ion-header>
          <ion-toolbar>
            <ion-title>Edit Video</ion-title>
            <ion-buttons slot="end">
              <ion-button @click="closeEditModal">Close</ion-button>
            </ion-buttons>
          </ion-toolbar>
        </ion-header>
        <ion-content class="ion-padding">
          <ion-item>
            <ion-label position="floating">Title</ion-label>
            <ion-input v-model="editVideo.title" type="text" required></ion-input>
          </ion-item>
          <ion-item>
            <ion-label position="floating">Description</ion-label>
            <ion-textarea v-model="editVideo.description" rows="3"></ion-textarea>
          </ion-item>
          <ion-button expand="block" @click="updateVideo" :disabled="loadingEdit">
            <ion-spinner v-if="loadingEdit" name="crescent"></ion-spinner>
            <span v-else>Save</span>
          </ion-button>
          <ion-text color="danger" v-if="errorMessageEdit">
            <p>{{ errorMessageEdit }}</p>
          </ion-text>
        </ion-content>
      </ion-modal>
    </ion-content>
    <footer />
  </ion-page>
</template>

<script lang="ts">
import { IonPage, IonHeader, IonToolbar, IonTitle, IonContent, IonList, IonItem, IonLabel, IonButton, IonText, IonSpinner, IonCard, IonCardHeader, IonCardTitle, IonCardContent, IonInput, IonTextarea, IonModal, IonButtons } from '@ionic/vue';
import { defineComponent, ref, onMounted, computed } from 'vue';
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

interface Video {
  id: number;
  title: string;
  description?: string;
  file_path: string;
  user_id: number;
}

export default defineComponent({
  name: 'Tab4Page',
  components: { IonPage, IonHeader, IonToolbar, IonTitle, IonContent, IonList, IonItem, IonLabel, IonButton, IonText, IonSpinner, IonCard, IonCardHeader, IonCardTitle, IonCardContent, IonInput, IonTextarea, IonModal, IonButtons, Navbar, Footer, FilePond },
  setup() {
    const router = useRouter();
    const videos = ref<Video[]>([]);
    const loading = ref<boolean>(false);
    const errorMessage = ref<string>('');

    // Formulari per crear un vídeo nou
    const pond = ref<FilePond | null>(null);
    const newVideo = ref<{ title: string; description: string; files: File[] }>({
      title: '',
      description: '',
      files: [],
    });
    const loadingCreate = ref<boolean>(false);
    const errorMessageCreate = ref<string>('');

    // Modal per editar un vídeo
    const isEditModalOpen = ref<boolean>(false);
    const editVideo = ref<Video | null>(null);
    const loadingEdit = ref<boolean>(false);
    const errorMessageEdit = ref<string>('');

    const isCreateButtonDisabled = computed(() => {
      return loadingCreate.value || !newVideo.value.title || newVideo.value.files.length === 0;
    });

    const fetchVideos = async () => {
      loading.value = true;
      errorMessage.value = '';
      try {
        console.log('Fetching videos...');
        const response = await apiClient.get('/media/my-videos');
        console.log('Videos response:', response.data);
        videos.value = Array.isArray(response.data) ? response.data : [];
        if (videos.value.length === 0) {
          console.log('No videos returned from API');
        }
      } catch (error: any) {
        console.error('Error fetching my videos:', error);
        errorMessage.value = error.response?.data?.message || 'Failed to load videos. Please try again.';
      } finally {
        loading.value = false;
      }
    };

    const playVideo = (filePath: string) => {
      const videoUrl = `http://localhost:8000/storage/${filePath}`;
      console.log('Playing video:', videoUrl);
      window.open(videoUrl, '_blank');
    };

    const handleFilePondInit = () => {
      console.log('FilePond has initialized');
    };

    const handleFileAdd = (error: FilePondErrorDescription | null, file: FilePondFile) => {
      if (error) {
        console.error('FilePond add file error:', error);
        errorMessageCreate.value = 'Error adding file: ' + error.main;
        return;
      }
      console.log('File added:', file.file.name, file.file.size, file.file.type);
      console.log('File instance:', file.file instanceof File);
      newVideo.value.files = [file.file];
    };

    const handleFilePondError = (error: FilePondErrorDescription) => {
      console.error('FilePond error:', error);
      errorMessageCreate.value = 'FilePond error: ' + error.main;
    };

    const createVideo = async () => {
      console.log('Starting createVideo...');
      console.log('Form data:', {
        title: newVideo.value.title,
        description: newVideo.value.description,
        filesLength: newVideo.value.files.length,
        file: newVideo.value.files[0] ? {
          name: newVideo.value.files[0].name,
          size: newVideo.value.files[0].size,
          type: newVideo.value.files[0].type,
          instance: newVideo.value.files[0] instanceof File,
        } : null,
      });

      if (!newVideo.value.files.length || !(newVideo.value.files[0] instanceof File)) {
        errorMessageCreate.value = 'Please select a valid video file.';
        return;
      }

      loadingCreate.value = true;
      errorMessageCreate.value = '';
      const formData = new FormData();
      formData.append('title', newVideo.value.title);
      formData.append('description', newVideo.value.description || '');
      formData.append('video', newVideo.value.files[0]);
      console.log('FormData prepared for upload:', Array.from(formData.entries()));

      try {
        const response = await apiClient.post('/media', formData);
        console.log('Create response:', response.data);
        newVideo.value.title = '';
        newVideo.value.description = '';
        newVideo.value.files = [];
        if (pond.value) {
          pond.value.removeFiles();
        }
        fetchVideos(); // Recarregar la llista de vídeos
      } catch (error: any) {
        console.error('Create error:', error.response?.data || error.message);
        errorMessageCreate.value = error.response?.data?.message || 'Upload failed. Please try again.';
      } finally {
        loadingCreate.value = false;
      }
    };

    const openEditModal = (video: Video) => {
      editVideo.value = { ...video };
      isEditModalOpen.value = true;
    };

    const closeEditModal = () => {
      isEditModalOpen.value = false;
      editVideo.value = null;
      errorMessageEdit.value = '';
    };

    const updateVideo = async () => {
      if (!editVideo.value) return;

      loadingEdit.value = true;
      errorMessageEdit.value = '';
      try {
        console.log('Updating video:', editVideo.value);
        const response = await apiClient.put(`/media/${editVideo.value.id}`, {
          title: editVideo.value.title,
          description: editVideo.value.description,
        });
        console.log('Update response:', response.data);
        fetchVideos(); // Recarregar la llista de vídeos
        closeEditModal();
      } catch (error: any) {
        console.error('Update error:', error.response?.data || error.message);
        errorMessageEdit.value = error.response?.data?.message || 'Failed to update video. Please try again.';
      } finally {
        loadingEdit.value = false;
      }
    };

    const deleteVideo = async (id: number) => {
      if (!confirm('Are you sure you want to delete this video?')) return;

      try {
        console.log('Deleting video:', id);
        const response = await apiClient.delete(`/media/${id}`);
        console.log('Delete response:', response.data);
        fetchVideos(); // Recarregar la llista de vídeos
      } catch (error: any) {
        console.error('Delete error:', error.response?.data || error.message);
        errorMessage.value = error.response?.data?.message || 'Failed to delete video. Please try again.';
      }
    };

    onMounted(() => {
      fetchVideos();
    });

    router.afterEach((to) => {
      if (to.path === '/tabs/my-videos') {
        fetchVideos();
      }
    });

    return {
      videos,
      loading,
      errorMessage,
      fetchVideos,
      playVideo,
      pond,
      newVideo,
      loadingCreate,
      errorMessageCreate,
      isCreateButtonDisabled,
      handleFilePondInit,
      handleFileAdd,
      handleFilePondError,
      createVideo,
      isEditModalOpen,
      editVideo,
      loadingEdit,
      errorMessageEdit,
      openEditModal,
      closeEditModal,
      updateVideo,
      deleteVideo,
    };
  },
});
</script>

<style scoped>
.ion-padding {
  display: flex;
  flex-direction: column;
  gap: 10px;
}
ion-card {
  width: 100%;
  max-width: 400px;
}
.filepond-wrapper {
  margin-top: 20px;
}
</style>