<template>
  <div>
    <q-layout view="lHh lpr lFf" style="height: 400px" class="shadow-2 rounded-borders">
      <q-header elevated class="bg-indigo">
        <q-toolbar>
          <q-toolbar-title>
            Admin Dashboard
          </q-toolbar-title>
          <q-btn-dropdown size="sm" flat :label="username">
            <q-list>
              <q-item clickable v-close-popup @click.native="showModalConfirmation">
                <q-item-section>
                  <q-item-label><i class="fas fa-sign-out-alt"></i> Logout</q-item-label>
                </q-item-section>
              </q-item>
            </q-list>
          </q-btn-dropdown>
        </q-toolbar>
      </q-header>

      <q-page-container>
        <q-page padding>
          <router-view />
        </q-page>
      </q-page-container>
    </q-layout>
    <confirmation-modal ref="confirmationModalRef" @confirm="logout"></confirmation-modal>
  </div>
</template>

<script>
  import ConfirmationModal            from "../pages/Admin/ConfirmationModal";

  export default {
    name: 'Layout',
    components : {
      ConfirmationModal
    },
    data: () => ({
      username : ''
    }),
    mounted () {
      this.username  = JSON.parse(localStorage.user).username;
    },
    methods: {
      myTweak (offset) {
        return { minHeight: offset ? `calc(100vh - ${offset}px)` : '100vh' }
      },
      showModalConfirmation(){
        this.$refs.confirmationModalRef.showConfirmationModal()
      },
      logout() {
        this.$store.commit('logout');
        this.$router.push('/')
      }
    }
  }
</script>
