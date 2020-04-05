<template>
  <div class="q-pa-md">
    <q-table
      dense
      :title="title"
      :data="data"
      :columns="columns"
      :pagination="{rowsPerPage: 10}"
      row-key="name"
      :loading="isLoading"
    >
      <q-tr slot="body" slot-scope="users" class="text-center">
        <slot :data="users.row" name="table-rows"></slot>
      </q-tr>
    </q-table>
  </div>
</template>

<script>
  export default {
    name: "GTable.vue",
    props: {
      title      : {type: String, default: ''},
      data       : {type: Array, default: () => []},
      columns    : {type: Array, default: () => []},
      pagination : {},
      isLoading  : {type: Boolean, default : false}
    }
  }
</script>

<style scoped>

</style>
