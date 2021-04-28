export const teamStore = {
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
        async fetchTeams({commit}) {
            return new Promise((resolve, reject) => {
                axios.get('teams/indexInstance').then(response => {
                    commit('setTeams', response.data);
                    resolve(response);
                }).catch(error => {
                    reject(error);
                });
            });
        },
    }
}
