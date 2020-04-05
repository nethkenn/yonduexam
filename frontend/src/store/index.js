import Vue from 'vue'
import Vuex from 'vuex'


Vue.use(Vuex)

/*
 * If not building with SSR mode, you can
 * directly export the Store instantiation;
 *
 * The function below can be async too; either use
 * async/await or return a Promise which resolves
 * with the Store instance.
 */

export default function (/* { ssrContext } */) {
  const Store = new Vuex.Store({
	  state : {
	    access_token: localStorage.getItem('access_token'),
			token_type: localStorage.getItem('token_type'),
			token_expire: localStorage.getItem('token_expire'),
      user: localStorage.getItem('user'),
    },
	  mutations: {
	    login (state, data)
      {
          state.access_token 		= data.access_token;
          state.token_type 	  	= data.token_type;
          state.token_expire 		= data.expires_in;
          state.user            = JSON.stringify(data.user);

          localStorage.setItem('access_token', data.access_token);
          localStorage.setItem('token_type', data.token_type);
          localStorage.setItem('token_expire', data.expires_in);
          localStorage.setItem('user', JSON.stringify(data.user));
      },
		logout (state)
		{
				state.access_token 		= null;
				state.token_type 		  = null;
				state.token_expire 		= null;
        state.user            = null;

				localStorage.removeItem('access_token');
				localStorage.removeItem('token_type');
				localStorage.removeItem('token_expire');
				localStorage.removeItem('user');
        localStorage.removeItem('vuex');
	    }
	},

    // enable strict mode (adds overhead!)
    // for dev mode only
    strict: process.env.DEV
  })

  return Store
}
