<script setup lang="ts">
import LoginForm from "../components/LoginForm.vue";
import LoginCarrousel from "../components/LoginCarrousel.vue";
import { onMounted } from "vue";
import { useRouter } from "vue-router";

const router = useRouter();

onMounted(() => {
    if (localStorage.token) router.push("/");
});
</script>

<template lang="pug">
.login
  LoginForm
  LoginCarrousel
</template>

<style lang="scss">
.login {
    display: flex;
    flex-direction: row;
    width: 100vw;
    height: 100vh;
    overflow: hidden;
}
</style>
