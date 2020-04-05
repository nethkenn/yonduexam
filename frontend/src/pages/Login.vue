<template>
  <div class="row q-ma-lg q-pa-md">
    <div class="col-12 col-lg-4 col-md-4"></div>
      <div class="q-pa-lg col-12 col-lg-4 col-md-4 shadow-1 rounded-borders">
        <div class="q-pa-md">
          <q-input v-model="form.username" stack-label  dense label="Username" />
        </div>
        <div class="q-pa-md">
          <q-input type="password" v-model="form.password" stack-label  dense label="Password" />
          <br>
          <q-banner v-if="error" dense rounded inline-actions class="text-white bg-red">
             Couldn't find your account
           </q-banner>
        </div>
        <div class='q-pa-md float-right'>
          <q-btn color="indigo"size="md" label="login" @click="login" icon="fas fa-sign-in-alt"/>
        </div>
      </div>
    <div class="col-12 col-lg-4 col-md-4"></div>
  </div>
</template>

<script>
export default {
  name: 'Login',
  data: () => ({
    form : {
        username : '',
        password : '',
    },
    error    : false
  }),
  methods: {
      login () {
        this.m_showPageLoading();
        axios.post('api/login', this.form  )
          .then(res => {
            this.$store.commit('login', res.data);
            axios.defaults.headers.common['Authorization'] = "Bearer "+ res.data.access_token;
            this.$router.push('/admin')
        })
        .catch(err => {
          this.error = true;
        })
       .finally(()=>{
          this.m_hidePageLoading();
        });
      }
    }
}
</script>
