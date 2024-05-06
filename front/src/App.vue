<template>
  <v-card>
   
    <v-tabs
      v-model="tab"
      bg-color="primary"
    >
      <v-tab value="users">Usuarios</v-tab>
      <v-tab value="assinaturas">Assinaturas</v-tab>
      <v-tab value="faturas">Faturas</v-tab>
    </v-tabs>
    

    <v-card-text>
      
      <v-tabs-window v-model="tab">
        <v-tabs-window-item value="users">         
          <TableUsers ref="tableUsers" />
        </v-tabs-window-item>

        <v-tabs-window-item value="assinaturas">
          <TableAssinatura  />
        </v-tabs-window-item>

        <v-tabs-window-item value="faturas">
          <TableFatura />
        </v-tabs-window-item>
      </v-tabs-window>
    </v-card-text>
  </v-card>
</template>
<script>

import TableUsers  from "./components/TableUsers.vue";
import TableAssinatura  from "./components/TableAssinatura.vue";
import TableFatura from "./components/TableFatura.vue";
  export default {
    components: {
      TableUsers,
      TableAssinatura,
      TableFatura
    },
    data: () => ({
      tab: null,
      users: [],
      message: '',
      typemessage: ''
    })
  }
</script>