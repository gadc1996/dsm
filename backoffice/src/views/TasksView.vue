<script setup lang="ts">
import { useTasksStore } from "@/stores/task";
import { onMounted, ref, watch } from "vue";
import ModalTask from "@/components/modals/ModalTask.vue";

const taskStore = useTasksStore();
const currentPage = ref(1);

onMounted(() => {
    taskStore.initialize();
});

watch(currentPage, (value) => {
    taskStore.loadResources(value);
});
</script>

<template lang="pug">
.view
  ModalTask
  h2.view__title Tareas
  v-row.d-flex.align-center.flex-column.mt-4
    v-card.table-wrapper
      h4.table-wrapper__title {{ strings.tasks_table }}
      h5.table-wrapper__subtitle {{ strings.tasks_table_subtitle }}
      v-btn.add-button(
        prepend-icon="mdi-plus"
        color="success"
        border
        @click="taskStore.openModal(-1, 'add')"
      ) {{ strings.add }}
      table.table
        thead
          tr
            th.text-left
              | #
            th.text-left
              | {{ strings.description }}
            th.text-left
              | {{ strings.created_by }}
            th.text-left
              | {{ strings.assigned_to}}
            th.text-left
              | {{ strings.status }}
            th.text-left
              | {{ strings.completation_date }}
        tbody
          tr(v-for="(task, index) in taskStore.resources")
            td {{ task.id }}
            td {{ task.description }}
            td {{ task.created_by.name }}
            td {{ task.assigned_to.name }}
            td 
              v-chip(
                :color="task.is_completed ? 'green' : 'gray'"
              ) {{ task.status_display }}
            td {{ task.completation_date }}
            td
              v-menu
                template(v-slot:activator="{ props }")
                  v-btn(
                    v-bind="props"
                  ) ...
                v-list
                  v-list-item(link @click="taskStore.openModal(index, 'update')")
                    v-icon mdi-pencil
                    v-list-item-title {{ strings.update }}
                  v-list-item(link @click="taskStore.openModal(index, 'delete')")
                    v-icon mdi-delete
                    v-list-item-title {{ strings.delete }}
      v-pagination(
        v-model="currentPage"
        :length="taskStore.lastPage"
        )
</template>

<style lang="scss">
.users {
}
</style>