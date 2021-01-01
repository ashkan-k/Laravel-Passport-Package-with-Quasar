
const routes = [
  {
    path: '/',
    component: () => import('layouts/MainLayout.vue'),
    children: [
      {
        path: '', component: () => import('pages/Index.vue')
      },
      {
        path: '/register', component: () => import('pages/Users/Form')
      },
      {
        path: '/edit/:id', component: () => import('pages/Users/Form')
      },
      {
        path: '/login', component: () => import('pages/Users/Login')
      },
      {
        path: '/all', component: () => import('pages/Users/Users')
      },
      {
        path: '/profile', component: () => import('pages/Users/Profile')
      },
      {
        path: '/logout', component: () => import('pages/Users/Logout')
      },
      {
        path: '/refresh_token', component: () => import('pages/Users/Refresh_Token')
      }
    ]
  },

  // Always leave this as last one,
  // but you can also remove it
  {
    path: '*',
    component: () => import('pages/Error404.vue')
  }
]

export default routes
