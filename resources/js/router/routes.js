import Landing from '../components/landing/Landing'
import Login from '../components/auth/Login'
import Register from '../components/auth/Register'
import Logout from "../components/auth/Logout";

import Servers from "../components/servers/Servers";
import Teams from "../components/teams/Teams";

const routes = [

    {
        path: '/',
        name: '/',
        component: Landing,
        meta: {
            title: 'hwGO'
        }
    },

    {
        path: '/register',
        name: 'register',
        component: Register,
        meta: {
            title: 'Register | hwGO',
            requiresVisitor: true,
        }
    },

    {
        path: '/login',
        name: 'login',
        component: Login,
        meta: {
            title: 'Login | hwGO',
            requiresVisitor: true,
        }
    },

    {
        path: '/logout',
        name: 'logout',
        component: Logout,
        meta: {
            title: 'Logout | hwGO',
            requiresAuth: true,
        }
    },

    {
        path: '/servers',
        name: 'servers',
        component: Servers,
        meta: {
            title: 'Servers | hwGO',
            requiresAuth: true,
        }
    },

    {
        path: '/teams',
        name: 'teams',
        component: Teams,
        meta: {
            title: 'Teams | hwGO',
            requiresAuth: true,
        }
    },
]

export default routes
