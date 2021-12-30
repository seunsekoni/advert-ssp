const routes = [
    {
        path: '',
        component: () => import('../Pages/Home.vue'),
        name: 'home'
    },
    {
        path: 'register',
        component: () => import('../Pages/Auth/Register.vue'),
        name: 'register'
    },
    {
        path: 'login',
        component: () => import('../Pages/Auth/Login.vue'),
        name: 'login'
    },
    {
        path: 'create/advert-campaigns',
        component: () => import('../Pages/Home.vue'),
        name: 'home'
    }
]

export default routes;