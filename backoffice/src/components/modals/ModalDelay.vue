<script setup lang="ts">
import { useDelaysStore } from "@/stores/delays";
import { computed, ref } from "vue";

let delayStore = useDelaysStore();

let buttonColor = computed(() => {
    return delayStore.modalType === "delete" ? "error" : "success";
});
</script>

<template lang="pug">
v-dialog.modal(v-model="delayStore.isModalVisible")
  v-card(
    min-width="50vw"
    class="modal"
  )
    v-card-title {{ strings[delayStore.modalType] }} {{ strings.user }}
    v-card-text(v-if="delayStore.modalType == 'delete'") {{ strings.delete_confirmation }}
    v-form(v-else)
      v-text-field(
        v-model="delayStore.selectedResource.description"
        label="Descripcion"
      )
      v-select(
        :items="delayStore.userTasks"
        item-title="description"
        item-value="id"
        v-model="delayStore.selectedResource.task_id"
      )
    v-card-actions
      v-btn(
        @click="delayStore.closeModal"
        color="gray"
      ) {{ strings.close }}
      v-btn(
        :color="buttonColor"
        @click="delayStore.submit"
        ) {{ strings[delayStore.modalType] }}
</template>

<style lang="scss">
.modal {
    padding: 2rem;
}
</style>
