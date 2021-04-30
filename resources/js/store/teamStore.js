export const teamModule = {
    state: {
        teams: [],
    },
    getters: {
        allTeams: (state) => {
            return state.teams
        }
    },
    mutations: {
        setTeams: (state, teams) => (state.teams = teams)
    },
    actions: {
        async addTeam(context, payload) {
            return new Promise((resolve, reject) => {
                axios.post('team/create', {
                    instance_id: payload.instance_id,
                    name: payload.name,
                    tag: payload.tag,
                    flag: payload.country,
                    logo: payload.image || null,
                    players: payload.players,
                }).then(response => {
                    this.dispatch('fetchTeams', {instance_id: payload.instance_id});
                    resolve(response);
                }).catch(error => {
                    reject(error);
                });
            });
        },
        async fetchTeams({commit}, payload) {
            return new Promise((resolve, reject) => {
                axios.get('team/indexInstance', {
                    params: {
                        instance_id: payload.instance_id
                    }
                }).then(response => {
                    console.log(response);
                    commit('setTeams', response.data);
                    resolve(response);
                }).catch(error => {
                    reject(error);
                });
            });
        },
    }
}
