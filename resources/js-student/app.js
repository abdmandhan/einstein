require('./bootstrap');

import Vue from 'vue';
import router from './router';
import vuetify from './vuetify' // path to vuetify export

import App from './App.vue'
import vueAwesomeCountdown from 'vue-awesome-countdown'

Vue.use(vueAwesomeCountdown, 'vac')

const files = require.context('./', true, /\.vue$/i)
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

//auth id
Vue.prototype.$userId = document.querySelector("meta[name='user-id']").getAttribute('content');
Vue.prototype.$baseUrl = document.querySelector("meta[name='base-url']").getAttribute('content');

new Vue({
    router,
    vuetify,
    el: '#app',
    render: h => h(App)
})
