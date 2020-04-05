export default {
  getUsers(){
    return axios.get('api/users')
      .then(response => {
         return response.data.users;
      })
  },
  deleteItem(id){
    return axios.delete('api/users/'+ id)
      .then(response => {
        return response
      })
  },
  deleteAll(ids){
    return axios.post('api/users/multipleDelete', {ids : ids} )
      .then(response => {
        return response
      })
  },

}
