const routes = [
  {
    path: '/',
    component: () => import('layouts/MinimumLayout.vue'),
    children: [
      { path: '', component: () => import('pages/LoginPage.vue') }
    ]
  },
  {
    path: '/register',
    component: () => import('layouts/MinimumLayout.vue'),
    children: [
      { path: '', component: () => import('pages/RegistrationPage.vue') }
    ]
  },
  {
    path: '/tasks',
    component: () => import('layouts/MinimumLayout.vue'),
    children: [
      { path: '', component: () => import('pages/TasksPage.vue') }
    ]
  },
  {
    path: '/:catchAll(.*)*',
    component: () => import('pages/ErrorNotFound.vue')
  }
]

export default routes
