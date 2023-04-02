<script setup lang="ts">
import { useTasksStore } from "@/stores/task";
import { onMounted, ref, watch } from "vue";
import ModalTaskComplete from "@/components/modals/ModalTaskComplete.vue";

const taskStore = useTasksStore();
const currentPage = ref(1);

onMounted(() => {
    taskStore.loadUserTasks();
});

function completeTask(task) {
  taskStore.openModalCompleteTask(task)
}

</script>

<template lang="pug">
.view
  ModalTaskComplete
  h2.view__title Mis Tareas
  v-row.d-flex.align-center.flex-column.mt-4
    v-card.table-wrapper
      v-card.task(
        theme="dark"
        v-for="task in taskStore.userTasks"
        @click="completeTask(task)"
      )
        v-card-title {{strings.description}} {{task.description}}
        v-card-subtitle {{strings.created_by}} {{task.created_by.name}}
        v-card-text {{strings.completation_date}}: {{task.completation_date}}
      //- table.table
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
              | {{ strings.completation_date }}
        tbody
          tr(v-for="(task, index) in taskStore.userTasks")
            td {{ task.id }}
            td {{ task.description }}
            td {{ task.created_by.name }}
            td {{ task.assigned_to.name }}
            td {{ task.completation_date }}
            td
              v-menu
                template(v-slot:activator="{ props }")
                  v-btn(
                    v-bind="props"
                  ) ...
                v-list
                  v-list-item(link @click="userStore.openModal(index, 'update')")
                    v-icon mdi-pencil
                    v-list-item-title {{ strings.update }}
                  v-list-item(link @click="userStore.openModal(index, 'delete')")
                    v-icon mdi-delete
                    v-list-item-title {{ strings.delete }}
</template>

<style lang="scss">
.task{
  margin: 1rem 0;
}
</style>
