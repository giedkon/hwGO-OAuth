import {authModule} from "./authStore";

export const serverModule = {
    state: {
        servers: [],
    },
    getters: {
        allServers: (state) => {
            return state.servers
        }
    },
    mutations: {
        setServers: (state, servers) => (state.servers = servers)
    },
    actions: {
        async fetchServers({commit}) {
            return new Promise((resolve, reject) => {
                axios.get('server/indexUser').then(response => {
                    commit('setServers', response.data);
                    resolve(response);
                }).catch(error => {
                    reject(error);
                });
            });
        },
        async addServer(context, payload) {
            return new Promise((resolve, reject) => {
                axios.post('server/create', {
                    name: payload.name,
                    address: payload.ip,
                    port: payload.port,
                    password: payload.rcon,
                    gotv_port: payload.gotv
                }).then(response => {
                    this.dispatch('fetchServers', {});
                    resolve(response);
                }).catch(error => {
                    reject(error);
                });
            });
        },
        async updateServer(context, payload) {
            return new Promise((resolve, reject) => {
                axios.patch('server/update', {
                    id: payload.id,
                    name: payload.name,
                    address: payload.ip,
                    port: payload.port,
                    password: payload.rcon,
                    gotv_port: payload.gotv
                }).then(response => {
                    this.dispatch('fetchServers', {});
                    resolve(response);
                }).catch(error => {
                    reject(error);
                });
            });
        },
        async removeServer(context, payload) {
            return new Promise((resolve, reject) => {
                axios.delete('server/destroy/'+ payload.server.id).then(response => {
                    this.dispatch('fetchServers', {});
                    resolve(response);
                }).catch(error => {
                    reject(error);
                });
            });
        },

    }
}
