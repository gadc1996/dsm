<script setup lang="ts">
import { useTasksStore } from "@/stores/task";
import { useUserStore } from "@/stores/user";
import { computed, ref } from "vue";
import InfiniteLoadingSelect from "@/components/InfiniteLoadingSelect.vue";

let taskStore = useTasksStore();

let buttonColor = computed(() => {
    return taskStore.modalType === "delete" ? "error" : "success";
});

async function handelInfiteLoading() {
  await taskStore.loadUsers()
}
</script>

<template lang="pug">
v-dialog.modal(v-model="taskStore.isModalTaskCompleteVisible")
  v-card(
    min-width="50vw"
    class="modal"
  )
    v-card-title {{ strings[taskStore.modalType] }} {{ strings.user }}
    v-card-text {{ strings.complete_confirmation }}
    v-card-actions
      v-btn(
        @click="taskStore.closeModalCompleteTask"
        color="gray"
      ) {{ strings.close }}
      v-btn(
        color="green"
        @click="taskStore.completeTask"
        ) Confirmar
</template>

<style lang="scss">
.modal {
    padding: 2rem;
}
</style>

