import axios from 'axios'

export default ({
    namespaced: true,

    state: {
        token: null,
        roles: null
    },

    getters: {
        authenticated (state) {
            return Boolean(state.token)
        },
        isAdmin (state) {
            if (state.roles) {
                return Boolean(state.roles.includes('ROLE_ADMIN'))
            }
            return false
        }
    },

    mutations: {
        SET_TOKEN (state, token) {
            state.token = token
        },
        SET_ROLES (state, roles) {
            state.roles = roles
        }
    },
    actions: {
        async signIn({ dispatch }, credentials) {
            
            credentials = JSON.stringify(credentials)
            let response = await axios.post('https://localhost:8000/user/login', credentials)
          
            dispatch('attempt', {token: response.data.token, roles: response.data.roles })
   
        },
        // TODO 
        async attempt({ commit, state }, {token, roles}) {


            if(token) {
                commit('SET_TOKEN', token)
                commit('SET_ROLES', roles)

            }
                        
            if(!state.token ) {
                return
            }

            try {
                await axios.get('https://localhost:8000/api/auth')

            }catch(e) {
                commit('SET_TOKEN', null)
                commit('SET_ROLES', null)
            }
        },
        signOut({commit}) {

            commit('SET_TOKEN', null)
            commit('SET_ROLES', null)     
        }
    } 
})
