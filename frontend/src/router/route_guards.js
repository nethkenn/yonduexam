export const beforeEnterLogin = (to, from, next) => {
  if(localStorage.getItem('access_token')) {

    next({name: 'admin'});
    return 0;
  }

  next();
};

export const beforeEnterAdmin = (to, from, next) => {
  if(!localStorage.getItem('access_token')) {

    next({name: 'login'});
    return 0;
  }

  next();
};

export default {
  beforeEnterAdmin,
  beforeEnterLogin
}