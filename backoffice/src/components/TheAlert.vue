<script setup lang="ts">
import { useAlertStore } from "@/stores/alert";

const alert = useAlertStore();
</script>

<template lang="pug">
.the-alert
  v-alert(:type="alert.type" :text="alert.message" v-if="alert.isVisible")
</template>
