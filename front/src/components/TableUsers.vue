<template>
    <v-alert v-if="message" :type="typemessage" dismissible>
              {{ message }}
    </v-alert>
    <v-data-table
      :headers="headers"
      :items="users"
      :sort-by="[{ key: 'codigo', order: 'asc' }]"
    >
      <template v-slot:top>        
        <v-toolbar
          flat
        >
        
          <v-toolbar-title>Usuarios</v-toolbar-title>
          <v-divider
            class="mx-4"
            inset
            vertical
          ></v-divider>
          <v-spacer></v-spacer>
          <v-dialog
            v-model="dialog"
            max-width="500px"
          >
            <template v-slot:activator="{ props }">                
              <v-btn
                class="mb-2"
                color="primary"
                dark
                v-bind="props"
              >
                Novo Usuário
              </v-btn>
            </template>
            <v-card>
              <v-card-title>
                <span class="text-h5">{{ formTitle }}</span>
              </v-card-title>
  
              <v-card-text>
                <v-container>
                    <v-alert v-if="message" :type="typemessage" dismissible>
                        {{ message }}
                    </v-alert>
                    <v-form ref='form'>
                        <v-row dense>
                            <v-col cols="12">
                            <v-text-field v-model="editedItem.name" label="Nome*" required ></v-text-field>
                            </v-col>
                
                            <v-col cols="12">
                            <v-text-field v-model="editedItem.email" label="Email*" required></v-text-field>
                            </v-col>

                            <v-col cols="12">
                            <v-text-field v-model="editedItem.telefone" label="Telefone" ></v-text-field>
                            </v-col>
                        </v-row>  
                    </v-form>
                </v-container>
              </v-card-text>
  
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn
                  color="blue-darken-1"
                  variant="text"
                  @click="close"
                >
                  Cancelar
                </v-btn>
                <v-btn
                  v-if="editedIndex === -1"
                  color="blue-darken-1"
                  variant="text"
                  @click="saveUser"
                >
                Salvar
                </v-btn>
                <v-btn
                  v-else
                  color="blue-darken-1"
                  variant="text"
                  @click="updateUser"
                >
                    Atualizar
                </v-btn>
              </v-card-actions>
            </v-card>
          </v-dialog>
          <v-dialog v-model="dialogDelete" max-width="700px">
            <v-card>
              <v-card-title class="text-h5">Deseja excluir o usuario {{ editedItem.name}}?</v-card-title>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue-darken-1" variant="text" @click="closeDelete">Cancelar</v-btn>
                <v-btn color="red-darken-1" variant="outlined" @click="deleteItemConfirm">Excluir</v-btn>
                <v-spacer></v-spacer>
              </v-card-actions>
            </v-card>
          </v-dialog>
        </v-toolbar>
      </template>
      <template v-slot:item.actions="{ item }">
        <v-icon
          class="me-2"
          size="small"
          @click="editItem(item)"
        >
          mdi-pencil
        </v-icon>
        <v-icon
          size="small"
          @click="deleteItem(item)"
        >
          mdi-delete
        </v-icon>
      </template>
      <template v-slot:no-data>
        <v-btn
          color="primary"
          @click="fetchUsers"
        >
          Reset
        </v-btn>
      </template>
    </v-data-table>
  </template>

<script>
import axios from 'axios';
export default {
    name: 'TableUsers',
    expose: ['fetchUsers'],
    data() {
        return {
            headers: [
                { title: 'Nome', key: 'name' },
                { title: 'Codigo', key: 'codigo'},
                { title: 'Email', key: 'email' },
                { title: 'Telefone', key: 'telefone' },
                { title: 'Açoes', key: 'actions', sortable: false },
            ],
            users: [],            
            loading: true,
            dialog: false,
            dialogDelete: false,            
            editedIndex: -1,
            editedItem: {
                id: '',
                name: '',
                email: '',
                telefone: ''
            },
            defaultItem: {
                name: '',
                email: '',
                telefone: ''
            },
            message: '',
            typemessage: ''
        };
    },
    computed: {
        formTitle() {
            return this.editedIndex === -1 ? 'Novo Usuário' : 'Editar Usuário';
        },
    },
    mounted() {
        this.fetchUsers();
    },
    methods: {
        fetchUsers() {
            // Fazer a requisição para a API /users e atribuir os dados à propriedade users
            // Exemplo usando axios:
            axios.get('/users')
                .then(response => {
                    this.users = response.data;
                    this.loading = false;
                })
                .catch(error => {
                    console.error(error);
                    this.loading = false;
                });
        },
        async saveUser() {            
            axios.post('/users', {
                ...this.editedItem
            })
                .then(response => { 
                  this.message = `Usuário ${response.data.name} cadastrado com sucesso!`;
                  this.users.push(response.data);
                  this.typemessage = 'success';                 
                  this.dialog = false;
                  this.$refs.form.reset();             
                })
                .catch(error => {
                console.error(error);
                this.message = error.response.data.message;
                this.typemessage = 'error';
                this.loading = false;
                });
        },
        async updateUser() {
            axios.put(`/users/${this.editedItem.id}`, {
                ...this.editedItem
            })
                .then(response => {
                    this.message = `Usuário ${response.data.name} atualizado com sucesso!`;
                    this.users[this.editedIndex] = response.data;
                    this.typemessage = 'success';
                    this.dialog = false;
                    this.$refs.form.reset();
                })
                .catch(error => {
                    console.error(error);
                    this.message = error.response.data.message;
                    this.typemessage = 'error';
                    this.loading = false;
                });
        },
        editItem (item) {
            this.editedIndex = this.users.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialog = true
        },
        deleteItemConfirm () {
            let name =  this.editedItem.name;
            axios.delete(`/users/${this.editedItem.id}`)
                .then(response => {
                    //faz uma copia do nome do usuario para exibir na mensagem
                    
                    this.message = `Usuário ${name} excluído com sucesso!`;
                    this.typemessage = 'success';
                    this.users.splice(this.editedIndex, 1);
                    this.closeDelete();
                })
                .catch(error => {
                    console.error(error);
                    this.message = error.response.data.message;
                    this.typemessage = 'error';
                    this.loading = false;
                });
            this.users.splice(this.editedIndex, 1)
            this.closeDelete()
        },
        deleteItem (item) {
            this.editedIndex = this.users.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialogDelete = true
        },
        close () {
            this.dialog = false
            this.$nextTick(() => {
            this.editedItem = Object.assign({}, this.defaultItem)
            this.editedIndex = -1
            })
      },
      closeDelete () {
        this.dialogDelete = false
        this.$nextTick(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
        })
      },
    },
    watch: {
      dialog (val) {
        val || this.close()
      },
      dialogDelete (val) {
        val || this.closeDelete()
      },
      message (val) {
        if (val) {
          setTimeout(() => {
            this.message = ''
          }, 4000)
        }
      }
    },
};
</script>