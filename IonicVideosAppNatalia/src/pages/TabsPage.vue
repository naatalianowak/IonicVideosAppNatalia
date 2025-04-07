<template>
  <ion-page>
    <ion-tabs>
      <ion-router-outlet></ion-router-outlet>
      <ion-tab-bar slot="bottom">
        <ion-tab-button tab="home" href="/tabs/home">
          <ion-icon :icon="homeOutline" />
          <ion-label>Home</ion-label>
        </ion-tab-button>

        <ion-tab-button tab="videos" href="/tabs/videos">
          <ion-icon :icon="videocamOutline" />
          <ion-label>Videos</ion-label>
        </ion-tab-button>

        <ion-tab-button v-if="canManageVideos" tab="manage-videos" href="/tabs/manage-videos">
          <ion-icon :icon="settingsOutline" />
          <ion-label>Manage Videos</ion-label>
        </ion-tab-button>
        <ion-tab-button tab="my-videos" href="/tabs/my-videos">
          <ion-icon :icon="personOutline()" />
          <ion-label>My Videos</ion-label>
        </ion-tab-button>
      </ion-tab-bar>
    </ion-tabs>
  </ion-page>
</template>

<script lang="ts">
import { IonTabBar, IonTabButton, IonTabs, IonLabel, IonIcon, IonPage, IonRouterOutlet } from '@ionic/vue';
import { defineComponent } from 'vue';
import {homeOutline, videocamOutline, settingsOutline, personOutline} from 'ionicons/icons';

export default defineComponent({
  name: 'TabsPage',
  methods: {
    personOutline() {
      return personOutline
    }
  },
  components: { IonLabel, IonTabs, IonTabBar, IonTabButton, IonIcon, IonPage, IonRouterOutlet },
  computed: {
    canManageVideos() {
      const rolesString = localStorage.getItem('roles') || '[]';
      console.log('Roles string from localStorage:', rolesString);
      let roles: string[] = [];
      try {
        roles = JSON.parse(rolesString);
        console.log('Parsed roles:', roles);
      } catch (error) {
        console.error('Error parsing roles from localStorage:', error);
        return false;
      }
      const requiredRoles = ['Video Manager', 'Super Admin'];
      console.log('Required roles:', requiredRoles);
      const hasRequiredRole = roles.some((role: string) => requiredRoles.includes(role));
      console.log('Has required role:', hasRequiredRole);
      return hasRequiredRole;
    },
  },
  setup() {
    return {
      homeOutline,
      videocamOutline,
      settingsOutline,
    };
  },
});
</script>