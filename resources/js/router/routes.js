import Landing from '../components/landing/Landing'
import Login from '../components/auth/Login'
import Register from '../components/auth/Register'
import Logout from "../components/auth/Logout";

import Servers from "../components/servers/Servers";

const routes = [

    {
        path: '/',
        name: '/',
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

    {
        path: '/servers',
        name: 'servers',
        component: Servers,
        meta: {
            requiresAuth: true,
        }
    },
]

export default routes
