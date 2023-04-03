<script setup lang="ts">
// import { useAuthStore } from "@/stores/auth";
import router from "@/router";
import { onMounted } from "vue";

// const auth = useAuthStore();

import { ref } from 'vue';
import type { Ref } from 'vue';
import  type { Link } from '@/types/Link'
import TheAlert from '@/components/TheAlert.vue'
onMounted(() => {
  if(!localStorage.token) router.push("/login") 
})

const isNavigationOpen: Ref<boolean> = ref(true)

const links: readonly Link[] = [
  {
    to: '/users',
    icon: 'mdi-account',
    text: 'Usuarios',
  },
  {
    to: '/tasks',
    icon: 'mdi-file-tree',
    text: 'Tareas',
  },
  {
    to: '/user-current-tasks',
    icon: 'mdi-calendar-check',
    text: 'Mis tareas actuales',
  },
  {
    to: '/user-pending-tasks',
    icon: 'mdi-calendar-clock',
    text: 'Mis tareas pendientes',
  },
  {
    to: '/delays',
    icon: 'mdi-timer-alert',
    text: 'Atrasos',
  },
]

function logout() {
  localStorage.removeItem("token");
  router.push("/login");
  
}
</script>

<template lang="pug">
.home
  v-app-bar
    template(v-slot:prepend)
      v-app-bar-nav-icon(
        @click="isNavigationOpen = !isNavigationOpen"
      )

  v-navigation-drawer(
    v-model="isNavigationOpen"
  )
    v-list 
      v-list-item(
        v-for="link in links"
        :prepend-icon="link.icon"
        :to="link.to"
        link
      )  {{ link.text }}

      v-list-item(
        @click="logout"
        prepend-icon="mdi-logout"
        link
      )  {{ strings.logout }}

  RouterView
      
</template>
