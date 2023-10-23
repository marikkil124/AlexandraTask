import {createRouter, createWebHistory} from "vue-router";

const router = createRouter({
    // 4. Provide the history implementation to use. We are using the hash history for simplicity here.
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [

        {
            path: '/api/equipment_type',
            component: () => import('../Equipment/create.vue')
        },


    ]
})

export default router
