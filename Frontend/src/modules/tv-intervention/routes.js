export default [
  {
    path: '/tv-intervention',
    name: 'tv-intervention.index',
    component: () => import('./views/tv-intervention-dashboard/index.vue'),
    meta: {
      requiresAuth: true,
      title: 'Can Thiệp TV',
    },
  },
]
