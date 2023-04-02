<script setup lang="ts">
import { useUserStore } from "@/stores/user";
import { computed, ref } from "vue";

let userStore = useUserStore();
let isPasswordVisible = ref(false);

let buttonColor = computed(() => {
    return userStore.modalType === "delete" ? "error" : "success";
});
</script>

<template lang="pug">
v-dialog.modal(v-model="userStore.isModalVisible")
  v-card(
    min-width="50vw"
    class="modal"
  )
    v-card-title {{ strings[userStore.modalType] }} {{ strings.user }}
    v-card-text(v-if="userStore.modalType == 'delete'") {{ strings.delete_confirmation }}
    v-form(v-else)
      v-text-field(
        v-model="userStore.selectedResource.name"
        label="Nombre"
      )
      v-text-field(
        v-model="userStore.selectedResource.email"
        label="Correo"
      )
      v-text-field(
        v-model="userStore.selectedResource.password"
        :label='strings.password'
        :type="isPasswordVisible ? 'text' : 'password'"
        :prepend-icon="isPasswordVisible ? 'mdi-eye' : 'mdi-eye-off'"
        @click:prepend="isPasswordVisible = !isPasswordVisible"
      )
    v-card-actions
      v-btn(
        @click="userStore.closeModal"
        color="gray"
      ) {{ strings.close }}
      v-btn(
        :color="buttonColor"
        @click="userStore.submit"
        ) {{ strings[userStore.modalType] }}
</template>

<style lang="scss">
.modal {
    padding: 2rem;
}
</style>
