import './assets/main.css'
import '@mdi/font/css/materialdesignicons.css' 
import { createApp } from 'vue'
import App from './App.vue'
import axios from 'axios';

// Vuetify
import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'

const vuetify = createVuetify({
    components,
    directives,
    icons: {
        iconfont: 'mdi',
    },
  })

axios.defaults.baseURL = 'http://localhost:8888/api';

createApp(App).use(vuetify).mount('#app')
