import { createWebHistory, createRouter } from "vue-router";
import store from '../store'

const router = new createRouter({
    history: createWebHistory(),
    linkActiveClass:'active',
    routes: [
        {
            path: "/:catchAll(.*)",
            name: "Page Not Found",
            component: () => import('../views/pages/_404.vue'),
            meta:{
                requiresAuth:false
            }
        },

        {
            path: "/",
            name: "Home",
            component: () => import('../views/pages/Home.vue'),
            meta:{
                requiresAuth:true
            }
        },
        {
            path: "/about",
            name: "About",
            component: () => import('../views/pages/About.vue'),
            meta:{
                requiresAuth:true
            }
        },
        {
            path: "/register",
            name: "Register",
            component: () => import('../views/components/Register.vue'),
            meta:{
                requiresAuth:false
            }
        },
        {
            path: "/login",
            name: "Login",
            component: () => import('../views/components/Login.vue'),
            meta:{
                requiresAuth:false
            }
        },
        {
            path: "/profile",
            name: "Profile",
            component: () => import('../views/components/Profile.vue'),
            meta:{
                requiresAuth:true
            }
        },
        {
            path: "/companies",
            name: "Companies",
            component: () => import('../views/components/Companies.vue'),
            meta:{
                requiresAuth:true
            }
        },
        {
            path: "/companies/create",
            name: "CreateCompany",
            component: () => import('../views/components/CreateCompany.vue'),
            meta:{
                requiresAuth:true
            }
        },
        {
            path: "/gigs",
            name: "Gigs",
            component: () => import('../views/components/Gigs.vue'),
            meta:{
                requiresAuth:true
            }
        },
        {
            path: "/gigs/create",
            name: "CreateGig",
            component: () => import('../views/components/CreateGig.vue'),
            meta:{
                requiresAuth:true
            }
        },
    ]
});

router.beforeEach((to,from) =>{
    if(to.meta.requiresAuth && store.getters.getToken == 0 && to.name !== 'Login'){
        return { name : 'Login'}
    }
})
export default router;
