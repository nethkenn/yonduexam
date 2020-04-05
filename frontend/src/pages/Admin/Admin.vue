<template>
  <div class="row q-ma-lg q-pa-md">
    <div class="col-12 col-md-12 col-sm-12">
      <q-btn @click.native="showAddUserModal" class="q-ma-sm float-right" color="indigo" size="sm" label="Add User" icon="fas fa-plus"/>
    </div>
    <div class="col-12 col-md-12 col-sm-12">
      <q-table
        dense
        :data="data"
        :loading="loading"
        :columns="columns"
        row-key="id"
        selection="multiple"
        :selected.sync="selected"
      >

        <tr slot="header" slot-scope="props">
          <q-th auto-width>
            <q-checkbox v-model="props.selected"
                        indeterminate-value="some"/>
          </q-th>

          <q-th v-if="item.name !== 'password'"
                v-for="item in columns"
                :key="item.name">
            {{item.label}}
          </q-th>

          <q-th v-else
                key="item.name"
                :class="password">
            {{item.label}}
          </q-th>

        </tr>

        <template slot="body" slot-scope="props">
          <q-tr :props="props">
            <q-td>
              <q-checkbox color="primary" v-model="props.selected" />
            </q-td>
            <q-td>{{props.row.firstName}}</q-td>
            <q-td>{{props.row.lastName}}</q-td>
            <q-td>{{props.row.username}}</q-td>
            <q-td :class="password">{{props.row.password}}</q-td>
            <q-td>{{props.row.address}}</q-td>
            <q-td>{{props.row.postCode}}</q-td>
            <q-td>{{props.row.contactNumber}}</q-td>
            <q-td>{{props.row.email}}</q-td>
            <q-td class="q-gutter-xs">
              <q-btn color="indigo" icon="edit" size="sm" label="Edit" @click="showEditUserModal(props.row)" />
              <q-btn color="indigo" v-if="user.id != props.row.id" icon="fas fa-trash" size="sm" label="Delete" @click="showConfirmationModal('deleteItem', props.row.id)" />
            </q-td>
          </q-tr>
        </template>

        <template v-slot:top="props">
          <q-btn color="indigo" icon="fas fa-trash" size="sm" label="Delete Selected" @click="showConfirmationModal('deleteSelected','')" />
          <q-space />
          <q-btn flat color="primary" :icon="passwordIcon" :label="passwordLabel" size="sm" @click="passwordToggle"/>
          <q-btn
            flat round dense
            :icon="props.inFullscreen ? 'fullscreen_exit' : 'fullscreen'"
            @click="props.toggleFullscreen"
            class="q-ml-md"
          />
        </template>
      </q-table>
    </div>
    <add-user-modal ref="addUserModalRef" @save="loadUsers"></add-user-modal>
    <edit-user-modal ref="editUserModalRef" @save="loadUsers"></edit-user-modal>
    <confirmation-modal ref="confirmationModalRef" @deleteSelected="deleteSelected" @deleteItem="deleteItem"
                        :title="confirmationSettings.title"
                        :icon="confirmationSettings.icon"
                        :color="confirmationSettings.color"
                        :btnColor="confirmationSettings.btnColor"
                        :function="confirmationSettings.function">
    </confirmation-modal>
  </div>
</template>

<script>
  import AddUserModal                 from "./AddUserModal";
  import Users                        from '../../models/Users';
  import GTable                       from "../../components/GTable";
  import ConfirmationModal            from "./ConfirmationModal";
  import EditUserModal                from "./EditUserModal";


  export default {
    name: 'Admin',
    components : {
      AddUserModal,
      GTable,
      ConfirmationModal,
      EditUserModal
    },
    data: () => ({
        user : {},
        confirmationSettings : {
          title        : "Are you sure you want to delete selected items?",
          icon         : "fas fa-trash",
          color        : 'negative',
          btnColor     : 'bg-red',
          function     : 'deleteSelected',
        },
        password : 'hidden',
        passwordIcon : 'fas fa-eye',
        passwordLabel : 'view password',
        selectedId : '',
        visibleColumns: [ 'firstName', 'lastName', 'address', 'postCode', 'contactNumber', 'email', 'username', 'action'],
        loading : false,
        selected: [],
        columns: [
               { field: 'firstName'     , name: 'firstName'     ,label: 'First Name'     , align: 'center',sortable: true},
               { field: 'lastName'      , name: 'lastName'      ,label: 'Last Name'      , align: 'center',sortable: true},
               { field: 'username'      , name: 'username'      ,label: 'Username'       , align: 'center',sortable: true},
               { field: 'password'      , name: 'password'      ,label: 'Password'       , align: 'center',sortable: true},
               { field: 'address'       , name: 'address'       ,label: 'Address'        , align: 'center',sortable: true},
               { field: 'postCode'      , name: 'postCode'      ,label: 'Post Code'      , align: 'center',sortable: true},
               { field: 'contactNumber' , name: 'contactNumber' ,label: 'Contact Number' , align: 'center',sortable: true},
               { field: 'email'         , name: 'email'         ,label: 'Email'          , align: 'center',sortable: true},
               { field: 'action'        , name: 'action'        ,label: 'Action'         , align: 'center',sortable: true},
             ],
         data: []
  }),
  methods: {
    passwordToggle() {
      this.password      = this.password      == 'hidden'        ? ''                 : 'hidden';
      this.passwordIcon  = this.passwordIcon  == 'fas fa-eye'    ? 'fas fa-eye-slash' : 'fas fa-eye';
      this.passwordLabel = this.passwordLabel == 'view password' ? 'hide password'    : 'view password';

    },
    showEditUserModal(data) {
      this.$refs.editUserModalRef.showEditUserModal(data)
    },
    showConfirmationModal(functionName, id){
      this.selectedId = id;
      this.confirmationSettings.title = functionName == "deleteItem" ?  "Are you sure you want to delete this item?"
                                                                      : "Are you sure you want to delete selected items?";
      this.confirmationSettings.function = functionName;
      this.$refs.confirmationModalRef.showConfirmationModal()
    },
    showAddUserModal(){
      this.$refs.addUserModalRef.showAddUserModal()
    },
    async deleteItem(){
      this.loading = true;
      await Users.deleteItem(this.selectedId).then(response => {
        this.notify({message : response.data.message})
        this.loadUsers()
        this.selected = [];
      })
    },
    async deleteSelected(){
      const ids = this.selected.map(v => { return v.id }).filter(v => v !== this.user.id);
      if(ids.length){
        this.loading = true;
        await Users.deleteAll(ids).then(response => {
          this.notify({message : response.data.message})
          this.loadUsers()
          this.selected = [];
        })
      }
    },
    async loadUsers() {
      this.loading = true;
      this.data = await Users.getUsers()
      this.loading = false;
    }
  },
  async mounted() {
      if (localStorage.user) {
        this.user  = JSON.parse(localStorage.user);
      }
      this.loadUsers()
  }
}
</script>
