<template>
  <div>
      <q-layout view="lHh lpr lFf" style="height: 400px" class="shadow-2 rounded-borders">
        <q-header elevated class="bg-indigo">
          <q-toolbar>
            <q-toolbar-title>
              Yondu Exam
            </q-toolbar-title>
          </q-toolbar>
        </q-header>

        <q-page-container>
          <q-page padding>
           <router-view />
          </q-page>
        </q-page-container>
      </q-layout>

   </div>
</template>

<script>

export default {
  name: 'Layout',
  methods: {
      myTweak (offset) {
        return { minHeight: offset ? `calc(100vh - ${offset}px)` : '100vh' }
      }
    }
}
</script>
