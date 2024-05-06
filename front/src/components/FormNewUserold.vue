<template>
    <div class="pa-4 text-center">
      <v-dialog
        v-model="dialog"
        max-width="600"
      >
        <template v-slot:activator="{ props: activatorProps }">
          <v-btn
            class="text-none font-weight-regular"
            prepend-icon="mdi-plus"
            text="Usuário"
            variant="outlined"
            v-bind="activatorProps"
          ></v-btn>
        </template>
  
        <v-card
          prepend-icon="mdi-plus"
          title="Novo Usuario"
        >
          <v-card-text>
            <v-form ref='form'>
              <v-row dense>
                <v-col cols="12">
                  <v-text-field v-model="name" label="Nome*" required ></v-text-field>
                </v-col>
    
                <v-col cols="12">
                  <v-text-field v-model="email" label="Email*" required></v-text-field>
                </v-col>

                <v-col cols="12">
                  <v-text-field v-model="telefone" label="Telefone" ></v-text-field>
                </v-col>
                </v-row>  
            </v-form>
            
          </v-card-text>
  
          <v-divider></v-divider>
  
          <v-card-actions>
            <v-spacer></v-spacer>
  
            <v-btn
              text="Cancelar"
              variant="plain"
              @click="dialog = false"
            ></v-btn>
  
            <v-btn
              color="primary"
              text="Salvar"
              variant="tonal"
              @click="saveUser"
            ></v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </div>
  </template>
  <script>
  import axios from 'axios';
    export default {
      data: () => ({
        dialog: false,
        name: '',
        email: '',
        telefone: '',
        loading: false,        
        users: []
      }),
      methods: {
        async saveUser() {            
            axios.post('/users', {
                name: this.name,                
                email: this.email,
                telefone: this.telefone
            })
                .then(response => {
                  this.$emit('newUser', response.data);                  
                  this.dialog = false;
                  this.$refs.form.reset();             
                })
                .catch(error => {                  
                this.message = error.response.data.message;
                this.typemessage = 'error';
                this.loading = false;
                });
        }
      }
    }
  </script>