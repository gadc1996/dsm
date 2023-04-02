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
    users: {
      data: [],
      pagination: {
        current_page: 0,
        last_page: 1
      }
    },
    isModalTaskCompleteVisible: false,
    selectedTask: {}
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
    async loadUsers(): Promise<void> {
      await this.$axios
        .get(`users?page=${this.$state.users.pagination.current_page + 1}`)
        .then((response: AxiosResponse) => {
          this.$state.users= {
            data: this.$state.users.data.concat(response.data.data),
            pagination: {
              current_page: response.data.current_page,
              last_page: response.data.last_page
            }
          }
        })
        .catch(() => {
          alert.setAlert('error', 'Error, intenta de nuevo')
        })
    },
    async initialize() {
      await this.loadResources()
      await this.loadUsers()
    },
    openModalCompleteTask(task) {
      this.$state.isModalTaskCompleteVisible = true
      this.$state.selectedTask = task
    },
    closeModalCompleteTask() {
      this.$state.isModalTaskCompleteVisible = false
      this.$state.selectedTask = {}
    },
    async completeTask() {
      await this.$axios
        .put(`/tasks/${this.$state.selectedTask.id}`, {
          is_completed: true
        })
        .then((response: AxiosResponse) => {
          const index = this.$state.userTasks.findIndex(task => task.id == this.$state.selectedTask.id)
          this.$state.userTasks.splice(index, 1)
          this.closeModalCompleteTask()
        })
        .catch(() => {
          alert.setAlert('error', 'Error, intenta de nuevo')
        })
    }
  }
})
