<script setup lang="ts">
import { ref } from "vue";
import type { Ref } from "vue";
import { useAuthStore } from "@/stores/auth";

const authStore = useAuthStore();

let isPasswordVisible: Ref<boolean> = ref(false);
</script>

<template lang="pug">
v-form.login-form(@submit.prevent="authStore.login")
  .logo
    img(src="@/assets/logo.svg")
  v-text-field(
    v-model='authStore.loginForm.email' 
    :label='strings.email'
    prepend-icon="mdi-email"
    required
    )

  v-text-field(
    v-model='authStore.loginForm.password' 
    :label='strings.password'
    :prepend-icon="isPasswordVisible ? 'mdi-eye' : 'mdi-eye-off'"
    :type="isPasswordVisible ? 'text' : 'password'"
    @click:prepend="isPasswordVisible = !isPasswordVisible"
    )
  v-btn(:disabled='authStore.isLoading' type='submit')
      span {{ strings.login }}
</template>

<style lang="scss">
.login-form {
    text-align: center;
    width: 90%;
    margin: auto;
    padding: 0 2%;
    .logo {
        img {
            max-width: 300px;
            aspect-ratio: 1;
            margin: 2rem 0;
        }
    }
}
</style>
