<script setup lang="ts">
import { useDelaysStore } from "@/stores/delays";
import { onMounted, ref, watch } from "vue";
import ModalDelay from '@/components/modals/ModalDelay.vue'

const delayStore = useDelaysStore();
const currentPage = ref(1);

onMounted(() => {
    delayStore.initialize();
});

watch(currentPage, (value) => {
    delayStore.loadResources(value);
});
</script>

<template lang="pug">
.view
  ModalDelay
  h2.view__title Atrasos
  v-row.d-flex.align-center.flex-column.mt-4
    v-card.table-wrapper
      h4.table-wrapper__title {{ strings.users_table }}
      h5.table-wrapper__subtitle {{ strings.users_table_subtitle }}
      v-btn.add-button(
        prepend-icon="mdi-plus"
        color="success"
        border
        @click="delayStore.openModal(-1, 'add')"
      ) {{ strings.add }}
      table.table
        thead
          tr
            th.text-left
              | #
            th.text-left
              | {{ strings.description }}
            th.text-left
              | {{ strings.task }}
            th.text-left
              | {{ strings.options }}
        tbody
          tr(v-for="(user, index) in delayStore.resources")
            td {{ user.id }}
            td {{ user.description }}
            td {{ user.task.description }}
            td
              v-menu
                template(v-slot:activator="{ props }")
                  v-btn(
                    v-bind="props"
                  ) ...
                v-list
                  v-list-item(link @click="delayStore.openModal(index, 'update')")
                    v-icon mdi-pencil
                    v-list-item-title {{ strings.update }}
                  v-list-item(link @click="delayStore.openModal(index, 'delete')")
                    v-icon mdi-delete
                    v-list-item-title {{ strings.delete }}
      v-pagination(
        v-model="currentPage"
        :length="delayStore.lastPage"
        )
</template>

<style lang="scss">
.users {
}
</style>
