<template>
  <ion-footer>
    <ion-toolbar>
      <ion-title>Created by Natalia - 2025</ion-title>
    </ion-toolbar>
  </ion-footer>
</template>

<script lang="ts">
import { IonFooter, IonToolbar, IonTitle } from '@ionic/vue';
import { defineComponent } from 'vue';

export default defineComponent({
  name: 'Footer',
  components: { IonFooter, IonToolbar, IonTitle },
});
</script>