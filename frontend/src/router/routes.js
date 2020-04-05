import {beforeEnterLogin, beforeEnterAdmin} from "./route_guards";

const routes = [
  {
    path        : '/',
    component   : () => import('layouts/Layout.vue'),
    beforeEnter : beforeEnterLogin,
    children    : [
      { path    : '', component: () => import('pages/Login.vue'), name : 'login' }
    ]
  },
  {
    path        : '/admin',
    component   : () => import('layouts/Layout.vue'),
    beforeEnter : beforeEnterAdmin,
    children    : [
      { path    : '', component: () => import('pages/Admin/Admin.vue'), name : 'admin'}
    ]
  }
]

// Always leave this as last one
if (process.env.MODE !== 'ssr') {
  routes.push({
    path: '*',
    component: () => import('pages/Error404.vue')
  })
}

export default routes
