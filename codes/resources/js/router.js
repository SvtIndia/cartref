
import VueRouter from 'vue-router'
import ExampleComponent from './components/Dashboard.vue'

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            name: 'dashboard',
            path: '/admin/dashboard',
            component: ExampleComponent,
        }
    ]
});


export default router;

