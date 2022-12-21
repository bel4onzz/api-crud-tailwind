
const apiRoutes = {
    registeruser: (payload) => {
        return axios.post('api/v1/register', payload)
    },
    loginuser: (payload) => {
        return axios.post('api/v1/login', payload)
    },
    logoutuser: () => {
        return axios.post('api/v1/logout')
    },
    userinfo: () => {
        return axios.post('api/v1/get-user-info')
    },
    updateuserinfo: (user_id, payload) => {
        return axios.put('api/v1/update-user-info/' + user_id, payload)
    },
    // Companies
    getusercompanies: () => {
        return axios.get('/api/v1/companies')
    },
    getcompany: (company_id) => {
        return axios.get('api/v1/companies/' + company_id)
    },
    createcompany: (payload) => {
        return axios.post("/api/v1/companies", payload);
    },
    updatecompany: (company_id, payload) => {
        return axios.put("api/v1/companies/" + company_id, payload);
    },
    destroycompany: (company_id) => {
        return axios.delete("api/v1/companies/" + company_id);
    },
    //Gigs
    getcompanygigs: (payload = 0) => {
        if(!payload){
            return axios.get('api/v1/gigs')
        }
        return axios.get('api/v1/gigs',{
            params: payload,
          })
    },
    getgig: (gig_id) => {
        return axios.get('api/v1/gigs/' + gig_id)
    },
    creategig: (payload) => {
        return axios.post("/api/v1/gigs", payload);
    },
    updategig: (gig_id, payload) => {
        return axios.put("api/v1/gigs/" + gig_id, payload);
    },
    destroygig: (gig_id) => {
        return axios.delete("api/v1/gigs/" + gig_id);
    }
}

export default apiRoutes
