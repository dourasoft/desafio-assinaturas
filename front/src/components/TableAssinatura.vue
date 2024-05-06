<template>
    <v-alert v-if="message" :type="typemessage" dismissible>
        {{ message }}
    </v-alert>
    <v-data-table
        :headers="headers"
        :items="assinaturas"
        :sort-by="[{ key: 'id', order: 'desc' }]"
    >
      <template v-slot:top>        
        <v-toolbar
          flat
        >
        
          <v-toolbar-title>Assinatura</v-toolbar-title>
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
                Nova Assinatura
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
                            <v-col  cols="12"><!-- Select de usuarios -->
                                <v-select
                                    v-model="editedItem.user_id"
                                    :item-props="itemProps"
                                    :items="users"
                                    :hint="editedItem.user.email"
                                    item-title="name"
                                    item-value="id"
                                    label="Cliente*"
                                    
                                ></v-select>                            
                            </v-col>
                
                            <v-col cols="12"><!-- Descriçao -->
                                <v-text-field v-model="editedItem.descricao" label="Descrição*" required></v-text-field>                            
                            </v-col>
                            <v-col cols="12">
                                <v-text-field v-model="editedItem.dia_vencimento" label="Dia de Vencimento*" required></v-text-field>
                            </v-col>                                
                            <v-col cols="12">
                                <v-text-field v-model="editedItem.valor" label="Valor*" required></v-text-field>                            
                            </v-col>
                            <v-col cols="12" v-if="editedIndex != -1">
                                <v-checkbox v-model="editedItem.ativo" label="Ativo"></v-checkbox>
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
                  @click="saveAssinatura"
                >
                Salvar
                </v-btn>
                <v-btn
                  v-else
                  color="blue-darken-1"
                  variant="text"
                  @click="updateAssinatura"
                >
                    Atualizar
                </v-btn>
              </v-card-actions>
            </v-card>
          </v-dialog>
          <v-dialog v-model="dialogDelete" max-width="700px">
            <v-card>
              <v-card-title class="text-h5">Deseja excluir a assinatura {{ editedItem.name}}?</v-card-title>
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
      <!-- Badge ativo-->
        <template v-slot:item.ativo="{ item }">
            <v-badge
            :content="item.ativo ? 'Ativo' : 'Inativo'"
            :color="item.ativo ? 'success' : 'error'"
            ></v-badge>
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
          @click="fetchAssinaturas"
        >
          Reset
        </v-btn>
      </template>
    </v-data-table>
</template>

<script>
import axios from 'axios';

export default {
    name: 'TableAssinatura',
    data() {
        return {
            headers: [
                
                { title: 'id', key: 'id'},
                { title: 'Status', key: 'ativo'},
                { title: 'Cliente', key: 'user.name' },
                { title: 'Descrição', key: 'descricao' },
                { title: 'Dia Vencimento', key: 'dia_vencimento'},
                { title: 'Valor', key: 'valor' },
                { title: 'Ações', key: 'actions', sortable: false },
            ],
            assinaturas: [],
            loading: true,
            dialog: false,
            dialogDelete: false,
            editedIndex: -1,
            editedItem: {
                id: '',
                user_id: '',
                descricao: '',
                dia_vencimento: '',
                valor: '',
                ativo: '',
                user: {
                    id: '',
                    name: '',
                },
                
            },
            defaultItem: {
              user_id: '',
                descricao: '',
                dia_vencimento: '',
                valor: '',
                ativo: 1,
                user: {
                    id: '',
                    name: '',
                },
            },
            message: '',
            typemessage: '',
            users: [],
        };
    },
    computed: {
        formTitle() {
            return this.editedIndex === -1 ? 'Nova Assinatura' : 'Editar Assinatura';
        },
    },
    mounted() {
        this.fetchAssinaturas();
        this.fetchUsers();
    },
    methods: {
        fetchAssinaturas() {
            axios
                .get('/assinaturas')
                .then((response) => {
                    this.assinaturas = response.data;
                    this.loading = false;
                })
                .catch((error) => {
                    console.error(error);
                    this.loading = false;
                });
        },
        fetchUsers() {
            axios
                .get('/users')
                .then((response) => {
                //recupera somente name e id
                    this.users = response.data.map((user) => ({
                        id: user.id,
                        name: user.name,
                        email: user.email,
                    }));
                    this.loading = false;
                })
                .catch((error) => {
                    console.error(error);
                    this.loading = false;
                });
        },
        async saveAssinatura() {
          this.editedItem.ativo = 1;
            axios
                .post('/assinaturas', {
                    ...this.editedItem,
                })
                .then((response) => {
                    this.message = `Assinatura de ${response.data.user.name} cadastrada com sucesso!`;
                    this.assinaturas.push(response.data);
                    this.typemessage = 'success';
                    this.dialog = false;
                    this.$refs.form.reset();
                })
                .catch((error) => {
                    console.error(error);
                    this.message = error.response.data.message;
                    this.typemessage = 'error';
                    this.loading = false;
                });
        },
        async updateAssinatura() {
            axios
                .put(`/assinaturas/${this.editedItem.id}`, {
                    ...this.editedItem,
                })
                .then((response) => {
                    this.message = `Assinatura ${response.data.cliente} atualizada com sucesso!`;
                    this.assinaturas[this.editedIndex] = response.data;
                    this.typemessage = 'success';
                    this.dialog = false;
                    this.$refs.form.reset();
                })
                .catch((error) => {
                    console.error(error);
                    this.message = error.response.data.message;
                    this.typemessage = 'error';
                    this.loading = false;
                });
        },
        editItem(item) {
            this.editedIndex = this.assinaturas.indexOf(item);
            console.log(item);
            this.editedItem = Object.assign({}, item);            
            this.dialog = true;
        },
        deleteItemConfirm() {
            let cliente = this.editedItem.user.name;
            axios
                .delete(`/assinaturas/${this.editedItem.id}`)
                .then((response) => {
                    this.message = `Assinatura  de ${cliente} excluída com sucesso!`;
                    this.typemessage = 'success';                                        
                })
                .catch((error) => {
                    console.error(error);
                    this.message = error.response.data.message;
                    this.typemessage = 'error';
                    this.loading = false;
                });
            this.assinaturas.splice(this.editedIndex, 1);
            this.closeDelete();
        },
        deleteItem(item) {
            this.editedIndex = this.assinaturas.indexOf(item);
            this.editedItem = Object.assign({}, item);
            this.dialogDelete = true;
        },
        close() {
            this.dialog = false;
            this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem);
                this.editedIndex = -1;
            });
        },
        closeDelete() {
            this.dialogDelete = false;
            this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem);
                this.editedIndex = -1;
            });
        },
        itemProps(item) {
            return {
                title: item.name,
                subtitle: item.email,
            };
        },
    },
    watch: {
        dialog(val) {
            val || this.close();
        },
        dialogDelete(val) {
            val || this.closeDelete();
        },
        message(val) {
            if (val) {
                setTimeout(() => {
                    this.message = '';
                }, 4000);
            }
        },
    },
};
</script>
