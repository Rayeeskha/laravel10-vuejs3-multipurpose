import './bootstrap';
import { createApp } from 'vue/dist/vue.esm-bundler';
import * as VueRouter from 'vue-router';

import LoaderComponent from './components/LoaderComponent.vue';

// Custom Routes
import Routes from './routes.js';

import Emitter from 'tiny-emitter';


const app = createApp({})

// Routes Initialize
const router = VueRouter.createRouter({
	routes : Routes,
	history:VueRouter.createWebHistory(),	
})



app.component('loader-component',LoaderComponent)

window.url = "http://127.0.0.1:8000/";

window.emitter = new Emitter()


// Router call
app.use(router)


// Mount div Id
app.mount('#app')
