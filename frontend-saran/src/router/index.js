import { createRouter, createWebHistory } from "vue-router";
import Dashboard from "../views/admin/Dashboard.vue";
import Tempat from "../views/admin/Penempatan.vue";
import Kategori from "../views/admin/Kategori.vue";
import Diagram from "../views/admin/Diagram.vue";
import Generate from "../views/admin/GenerateQR.vue";
import Tab from "../components/Form-qr.vue";
import FormSaran from "../views/user/FormSaran.vue";
import QRreader from "../views/user/QRreader.vue";
import ClosingPage from "../views/user/ClosingPage.vue";
import Login from "../views/Login.vue";
import Test from "../views/admin/test.vue";


const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
          path: "/dashboard",
          name: 'Dashboard',
          component: Dashboard,
          meta: {
            requireAuth: true
          }
        },
        {
          path: "/tempat",
          name: 'Tempat',
          component: Tempat,
          meta: {
            requireAuth: true
          }
        },
        {
          path: "/kategori",
          name: 'Kategori',
          component: Kategori,
          meta: {
            requireAuth: true
          }
        },
        {
          path: "/diagram",
          name: 'Diagram',
          component: Diagram,
          meta: {
            requireAuth: true
          }
        },
        {
          path: "/generate",
          name: 'Generate',
          component: Generate,
          meta: {
            requireAuth: true
          }
        },
        {
          path: "/test",
          name: 'Test',
          component: Test,
          meta: {
            requireAuth: true
          }
        },
        {
          path: "/tabs",
          name: 'Tab',
          component: Tab,
          meta: {
            requireAuth: true
          }
        },
        {
          path: "/loginAdmin",
          name: 'Login',
          component: Login,
          meta: {
            requireAuth: false
          }
        },
        {
          path: "/",
          name: 'QRreader',
          component: QRreader,
          meta: {
            requireAuth: false
          }
        },
        {
          path: "/form-saran",
          name: 'FormSaran',
          component: FormSaran,
          meta: {
            requireAuth: false
          }
        },
        {
          path: "/close",
          name: 'ClosingPage',
          component: ClosingPage,
          meta: {
            requireAuth: false
          }
        },    
    ]
});

router.beforeEach((to, from, next) => {

  const token = localStorage.getItem('token')
  const isAdmin = to.matched.some(record => record.meta.requireAuth)
  const user = ['/', '/form-saran', '/close']

  if (token && to.path === '/loginAdmin') {
    next('/dashboard')
  }else if (token || to.meta.requireAuth === false || to.path === '/loginAdmin') {
    next()
  }else if (!token && isAdmin) {
    next('/')
  }
  else if (!user.includes(to.path)) {
    next('/')
  }
  else {
    next('/loginAdmin')
  }

});
export default router