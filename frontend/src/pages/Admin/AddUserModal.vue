<template>
  <g-modal ref="gModalRef" :title="modalTitle" :icon="modalIcon">
      <span slot="content">
        <div class="row">
          <div class="q-pa-md col">
            <q-input label="First Name" stack-label dense
                     v-model="form.firstName"
                     :error="errors.hasOwnProperty('firstName')"
                     :error-message="errors.hasOwnProperty('firstName') ? errors.firstName[0] : ''"/>
          </div>
          <div class="q-pa-md col">
            <q-input label="Last Name" stack-label dense
                     v-model="form.lastName"
                     :error="errors.hasOwnProperty('lastName')"
                     :error-message="errors.hasOwnProperty('firstName') ? errors.lastName[0] : ''"/>
          </div>
        </div>
        <div class="row">
          <div class="q-pa-md col">
            <q-input label="Username" stack-label dense
                     v-model="form.username"
                     :error="errors.hasOwnProperty('username')"
                     :error-message="errors.hasOwnProperty('username') ? errors.username[0] : ''"/>
          </div>
          <div class="q-pa-md col">
            <q-input type="password" label="Password" stack-label dense
                     v-model="form.password"
                     :error="errors.hasOwnProperty('password')"
                     :error-message="errors.hasOwnProperty('password') ? errors.password[0] : ''"/>
          </div>
        </div>
        <div class="row">
          <div class="q-pa-md col">
            <q-input label="Address" stack-label dense
                     v-model="form.address"/>
          </div>
          <div class="q-pa-md col">
            <q-input label="Post Code" stack-label dense
                     v-model="form.postCode"/>
          </div>
        </div>
        <div class="row">
          <div class="q-pa-md col">
            <q-input label="Contact Number" stack-label dense
                     v-model="form.contactNumber"/>
          </div>
          <div class="q-pa-md col">
            <q-input type="email" label="Email" stack-label dense
                     v-model="form.email"
                     :error="errors.hasOwnProperty('email')"
                     :error-message="errors.hasOwnProperty('email') ? errors.email[0] : ''"/>
          </div>
        </div>

      </span>

    <span slot="actions">
        <div class="q-gutter-xs">
          <q-btn class="bg-white text-indigo" outline icon="close"  label="close" style="font-size:12px"
                 @click="hideAddUserModal()"/>
          <q-btn class="bg-indigo" icon="save"  flat label="Confirm"  style="font-size:12px"
                 @click="save()"/>
        </div>
      </span>
  </g-modal>
</template>

<script>
  import GModal                  from "../../components/GModal";

  export default {
    name: "AddUserModal.vue",
    components: {
      GModal
    },
    data : () => ({
      modalTitle: "ADD USER",
      modalIcon: "fas fa-plus",
      form : {
        firstName : '',
        lastName  : '',
        username  : '',
        password  : '',
        address   : '',
        postCode  : '',
        contactNumber : '',
        email     : ''
      },
      errors : []
    }),
    methods : {
      save(){
        this.errors = [];
        this.m_showPageLoading();
        axios.post('api/users', this.form  )
          .then(res => {
            this.notify({message : res.data.message})
            this.$emit('save')
            this.clearField()
            this.$refs.gModalRef.hideModal()
          })
          .catch(err => {
            if(err.response.status === 422) {
              this.errors = err.response.data.errors;
            }
          })
          .finally(()=>{
            this.m_hidePageLoading();
          });
      },
      clearField(){
          this.form = {
            firstName : '',
            lastName  : '',
            username  : '',
            password  : '',
            address   : '',
            postCode  : '',
            contactNumber : '',
            email : ''
          }
      },
      showAddUserModal(){
        this.$refs.gModalRef.showModal()
      },
      hideAddUserModal(){
        this.clearField()
        this.$refs.gModalRef.hideModal()
      }
    },
  }
</script>

<style scoped>

</style>
