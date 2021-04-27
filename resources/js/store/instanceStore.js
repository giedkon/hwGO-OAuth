export const instanceModule = {
    state: {
        instance: localStorage.getItem('instance_id') || null,
        instances: JSON.parse(localStorage.getItem('instances') || "{}")
    },
    getters: {
        instance(state) {
            return state.instance
        },
        currentInstance(state) {
            return state.instances.filter(instance => instance.id == state.instance)[0]
        },
        instances(state) {
            return state.instances
        },
    },
    mutations: {
        setInstance(state, instance_id) {
            localStorage.setItem('instance_id', instance_id)
            state.instance = instance_id
        },
        setInstances(state, instanceArray) {
            localStorage.setItem('instances', JSON.stringify(instanceArray))
            state.instances = instanceArray
        },
        destroyToken(state) {
            state.token = null
        },
    },
    actions: {
        setInstance(context, instance_id) {

            context.commit('setInstance', instance_id);
        },
        async fetchInstances({commit}) {
            return new Promise((resolve, reject) => {
                axios.get('instance/indexUser').then(response => {
                    commit('setInstances', response.data);
                    resolve(response);
                }).catch(error => {
                    reject(error);
                });
            });
        },
        async addInstance(context, payload) {
            return new Promise((resolve, reject) => {
                axios.post('instance/create', payload, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }).then(response => {
                    this.dispatch('fetchInstances', {});
                    resolve(response);
                }).catch(error => {
                    reject(error);
                });
            });
        },
        async updateInstance(context, payload) {
            return new Promise((resolve, reject) => {
                axios.post('instance/update', payload, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }).then(response => {
                    this.dispatch('fetchInstances', {});
                    resolve(response);
                }).catch(error => {
                    reject(error);
                });
            });
        },
        async removeInstance(context, payload) {
            return new Promise((resolve, reject) => {
                axios.delete('instance/destroy/'+ payload.instance.id).then(response => {
                    this.dispatch('fetchInstances', {});
                    context.commit('setInstance', null);
                    resolve(response);
                }).catch(error => {
                    reject(error);
                });
            });
        },
    }
}
