import { isAdminAuthenticated } from './middleware';

const admin = {
    path: '/admin',
    redirect: '/admin/products',
    component: () => import('../layouts/admin.vue'),
    beforeEnter: isAdminAuthenticated,
    children: [
        {
            path: 'users',
            name: 'admin-users',
            component: () => import('../views/admin/users/index.vue'),
            beforeEnter: isAdminAuthenticated,
        },
        {
            path: 'admins',
            name: 'admin-admins',
            component: () => import('../views/admin/admins/index.vue'),
            beforeEnter: isAdminAuthenticated,
        },
        {
            path: 'products',
            name: 'admin-products',
            component: () => import('../views/admin/products/index.vue'),
            beforeEnter: isAdminAuthenticated,
        },
        {
            path: 'orders',
            name: 'admin-orders',
            component: () => import('../views/admin/orders/index.vue'),
            beforeEnter: isAdminAuthenticated,
        },
        {
            path: 'uploadProduct',
            name: 'upload-product',
            component: () => import('../views/admin/products/uploadProduct.vue'),
            beforeEnter: isAdminAuthenticated,
        },
        {
            path: 'test',
            name: 'admin-test',
            component: () => import('../views/admin/test/index.vue'),
            beforeEnter: isAdminAuthenticated,
        },
        {
            path: 'login',
            name: 'admin-login',
            component: () => import('../views/admin/login.vue'),
            beforeEnter: isAdminAuthenticated,
        },
        {
            path: 'account',
            name: 'admin-account',
            component: () => import('../views/admin/account/index.vue'),
            beforeEnter: isAdminAuthenticated,
        }
    ]
}

export default admin;