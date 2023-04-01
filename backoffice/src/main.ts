import { createApp } from 'vue'
import pinia from './plugins/pinia'
import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import '@mdi/font/css/materialdesignicons.css'
import strings from './plugins/strings'

const vuetify = createVuetify({
  components,
  directives,
})

import App from './App.vue'
import router from './router'


const app = createApp(App)

app.use(pinia)
app.use(router)
app.use(vuetify)
app.use(strings)

app.mount('#app')
