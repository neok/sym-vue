import { createWebHistory, createRouter } from "vue-router";
import Dashboard from "./components/Dashboard.vue";
import Login from "./components/Login.vue";
import Events from './components/Events.vue'
import Tickets from './components/tickets/List.vue'
import EditTicket from './components/tickets/Edit.vue'
import CreateTicket from './components/tickets/Create.vue'

const routes = [
  {
    path: "/dashboard",
    name: "dashboard",
    component: Dashboard,
  },

  {
    path: "/login",
    name: "login",
    component: Login,
  },
  {
    path: '/events/:id',
    name: 'Events',
    component: Events
  },
  {
    path: '/events/:id/tickets',
    name: 'Tickets',
    component: Tickets
  },
  {
    path: '/events/:eventId/tickets/create',
    name: 'CreateTicket',
    component: CreateTicket
  },
  {
    path: '/events/:eventId/tickets/:id',
    name: 'EditTicket',
    component: EditTicket
  },

];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

router.beforeEach((to, from, next) => {
  const publicPages = ['/login'];
  const authRequired = !publicPages.includes(to.path);
  const loggedIn = localStorage.getItem('user');

  if (authRequired && !loggedIn) {
    next('/login');
  } else {
    next();
  }
});

export default router;
