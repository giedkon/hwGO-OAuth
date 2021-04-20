import Landing from '../components/landing/Landing'
import Login from '../components/auth/Login'
import Register from '../components/auth/Register'
import Logout from "../components/auth/Logout";

const routes = [

    {
        path: '/',
        name: 'home',
        component: Landing
    },

    {
        path: '/register',
        name: 'register',
        component: Register,
        meta: {
            requiresVisitor: true,
        }
    },

    {
        path: '/login',
        name: 'login',
        component: Login,
        meta: {
            requiresVisitor: true,
        }
    },

    {
        path: '/logout',
        name: 'logout',
        component: Logout,
        meta: {
            requiresAuth: true,
        }
    },
]

export default routes
