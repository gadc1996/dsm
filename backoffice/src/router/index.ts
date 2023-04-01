import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView
    },
    {
      path: '/users',
      name: 'users',
      component: () => import('../views/UsersView.vue')
    },
    {
      path: '/tasks',
      name: 'tasks',
      component: () => import('../views/TasksView.vue')
    },
    {
      path: '/user-current-tasks',
      name: 'userCurrentTasks',
      component: () => import('../views/UserCurrentTasksView.vue')
    },
    {
      path: '/user-pending-tasks',
      name: 'UserPendingTasks',
      component: () => import('../views/UserPendingTasksView.vue')
    }
  ]
})

export default router
