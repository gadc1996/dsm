import Crud from "@/composables/crud";
import { defineStore } from "pinia";
import type { AxiosResponse } from "axios";

const crud = new Crud("tasks");

export const useTasksStore = defineStore({
  id: 'task',
  state: () => ({
    ...crud.state,
    userTasks: [],
    pendingTasks: [],
  }),
  getters: {},
  actions: {
    ...crud.actions,
    async loadUserTasks(page = 1): Promise<void> {
      this.setHeaders()
      await this.$axios
        .get('users/2/tasks/current')
        .then((response: AxiosResponse) => {
          this.$state.userTasks = response.data
        })
        .catch(() => {
          alert.setAlert('error', 'Error, intenta de nuevo')
        })
    },
    async loadPendingUserTasks(page = 1): Promise<void> {
      this.setHeaders()
      await this.$axios
        .get('users/2/tasks/pending')
        .then((response: AxiosResponse) => {
          this.$state.pendingTasks = response.data
        })
        .catch(() => {
          alert.setAlert('error', 'Error, intenta de nuevo')
        })
    },
    async initialize() {
      await this.loadResources()
    }
  }
})
