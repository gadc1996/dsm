<script setup lang="ts">
import { useUserStore } from "@/stores/user";
import { onMounted, ref, watch } from "vue";
// import ModalUser from "@/components/modals/ModalUser.vue";

const userStore = useUserStore();
const currentPage = ref(1);

onMounted(() => {
    userStore.initialize();
});

watch(currentPage, (value) => {
    userStore.loadResources(value);
});
</script>

<template lang="pug">
.view
  //- ModalUser
  h2.view__title Usuarios
  v-row.d-flex.align-center.flex-column.mt-4
    v-card.table-wrapper
      h4.table-wrapper__title {{ strings.users_table }}
      h5.table-wrapper__subtitle {{ strings.users_table_subtitle }}
      v-btn.add-button(
        prepend-icon="mdi-plus"
        color="success"
        border
        @click="userStore.openModal(-1, 'add')"
      ) {{ strings.add }}
      table.table
        thead
          tr
            th.text-left
              | #
            th.text-left
              | {{ strings.name }}
            th.text-left
              | {{ strings.email }}
            th.text-left
              | {{ strings.options }}
        tbody
          tr(v-for="(user, index) in userStore.resources")
            td {{ user.id }}
            td {{ user.name }}
            td {{ user.email }}
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
      v-pagination(
        v-model="currentPage"
        :length="userStore.lastPage"
        )
</template>

<style lang="scss">
.users {
}
</style>