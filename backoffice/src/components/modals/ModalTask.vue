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
v-dialog.modal(v-model="taskStore.isModalVisible")
  v-card(
    min-width="50vw"
    class="modal"
  )
    v-card-title {{ strings[taskStore.modalType] }} {{ strings.user }}
    v-card-text(v-if="taskStore.modalType == 'delete'") {{ strings.delete_confirmation }}
    v-form(v-else)
      v-text-field(
        v-model="taskStore.selectedResource.description"
        label="Descripcion"
      )
      v-text-field(
        v-model="taskStore.selectedResource.completation_date"
        label="Fecha de terminacion"
        type="date"
      )
      label {{ strings.role }}
      InfiniteLoadingSelect(
        :items="taskStore.users.data"
        items-text="name"
        items-value="id"
        v-model="taskStore.selectedResource.assigned_to_id"
        @infinite="handelInfiteLoading"
        :pagination="taskStore.users.pagination"
      )
    v-card-actions
      v-btn(
        @click="taskStore.closeModal"
        color="gray"
      ) {{ strings.close }}
      v-btn(
        :color="buttonColor"
        @click="taskStore.submit"
        ) {{ strings[taskStore.modalType] }}
</template>

<style lang="scss">
.modal {
    padding: 2rem;
}
</style>
