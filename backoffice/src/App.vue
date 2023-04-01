<script setup lang="ts">
import { ref } from 'vue';
import type { Ref } from 'vue';
import  type { Link } from '@/types/Link'

const isNavigationOpen: Ref<boolean> = ref(false)

const links: readonly Link[] = [
  {
    to: '/users',
    icon: 'mdi-home',
    text: 'Usuarios',
  },
  {
    to: '/tasks',
    icon: 'mdi-home',
    text: 'Tareas',
  },
  {
    to: '/user-current-tasks',
    icon: 'mdi-home',
    text: 'Mis tareas actuales',
  },
  {
    to: '/user-pending-tasks',
    icon: 'mdi-home',
    text: 'Mis tareas pendientes',
  },
  {
    to: '/delays',
    icon: 'mdi-home',
    text: 'Atrasos',
  },
]
</script>

<template lang="pug">
v-app 
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
      
  v-main 
    RouterView

</template>

<style></style>
