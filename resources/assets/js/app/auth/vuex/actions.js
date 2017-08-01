import {setHttpToken} from "../../../helpers"

export const register = ({ dispatch }, { payload, context }) => {

    return axios.post('/api/register', payload).then( (response) => {

        console.log(response)
    }).catch((error) => {
        context.errors = error.response.data.errors
    })
}

export const login = ( { dispatch }, { payload, context }) => {

    return axios.post('/api/login', payload).then( (response) => {

        console.log(response)

        //set token
        dispatch('setToken', response.data.meta.token ).then(() => {

            dispatch('fetchUser')

            console.log('fetch user')
        })

    }).catch((error) => {
        context.errors = error.response.data.errors
    })
}

export const setToken = ( { commit, dispatch }, token) => {

    commit('setToken', token)

    //set http token
    setHttpToken(token)
}

export const fetchUser = ( { commit }) => {

    return axios.get('/api/me').then((response) => {

        commit('setAuthenticated', true)
        commit('setUserData', response.data.data)
    })
}