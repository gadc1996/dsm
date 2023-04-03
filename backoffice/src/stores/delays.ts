import Crud from "@/composables/crud";
import { defineStore } from "pinia";
import type { AxiosResponse } from "axios";

const crud = new Crud("delays");

export const useDelaysStore = defineStore({
  id: 'delay',
  state: () => ({
    ...crud.state,
    userTasks: []
  }),
  getters: {},
  actions: {
    ...crud.actions,
    async loadUserTasks(): Promise<void> {
      this.setHeaders()
      await this.$axios
        .get('users/2/tasks/')
        .then((response: AxiosResponse) => {
          this.$state.userTasks = response.data
        })
        .catch(() => {
          alert.setAlert('error', 'Error, intenta de nuevo')
        })
    },
    async initialize() {
      await this.loadResources()
      await this.loadUserTasks()
    }
  }
})
