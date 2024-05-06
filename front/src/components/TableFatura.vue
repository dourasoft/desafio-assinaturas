<template>
    <v-alert v-if="message" :type="typemessage" dismissible>
        {{ message }}
    </v-alert>
    <v-data-table
        :headers="headers"
        :items="faturas"
        :sort-by="[{ key: 'id', order: 'desc' }]"
    >
      <template v-slot:top>        
        <v-toolbar
          flat
        >
        
          <v-toolbar-title>Faturas</v-toolbar-title>
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
                Nova Fatura
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
                            <v-col  cols="12">
                                <v-select
                                    v-model="editedItem.assinatura_id"
                                    :items="assinaturas"
                                    :item-props="itemProps"
                                    :hint="editedItem.descricao"
                                    item-title="user.name"
                                    item-value="id"
                                    label="Assinaturas*"
                                    
                                ></v-select>                            
                            </v-col>
                
                            <v-col cols="12">
                                <v-text-field v-model="editedItem.descricao" label="Descrição*" required></v-text-field>                            
                            </v-col>
                            <v-col cols="12">
                                <v-text-field v-model="editedItem.data_vencimento" label="Data de Vencimento dd/mm/yyyy*" required return-masked-value
    mask="##/##/####"></v-text-field>                                
                            </v-col>                                
                            <v-col cols="12">
                                <v-text-field v-model="editedItem.valor" label="Valor*" required></v-text-field>                            
                            </v-col>
                            <v-col cols="12" v-if="editedIndex != -1">
                                <v-select
                                    v-model="editedItem.status"
                                    :items="['aberta', 'paga', 'cancelada']"
                                    label="Status*"
                                    required
                                ></v-select>                                
                            </v-col>
                            <v-col cols="12" v-if="editedItem.status == 'paga'">
                                <v-text-field v-model="editedItem.data_pagamento" label="Data de Pagamento dd/mm/yyyy*" required></v-text-field>
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
                  @click="savefatura"
                >
                Salvar
                </v-btn>
                <v-btn
                  v-else
                  color="blue-darken-1"
                  variant="text"
                  @click="updatefatura"
                >
                    Atualizar
                </v-btn>
              </v-card-actions>
            </v-card>
          </v-dialog>
          <v-dialog v-model="dialogDelete" max-width="700px">
            <v-card>
              <v-card-title class="text-h5">Deseja excluir a fatura {{ editedItem.name}}?</v-card-title>
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
      <!-- Badge status-->
        <template v-slot:item.status="{ item }">
            <v-badge
            :content="item.status"
            :color="item.status == 'aberta' ? 'primary' : item.status == 'paga' ? 'success' : 'error'"
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
          @click="fetchfaturas"
        >
          Reset
        </v-btn>
      </template>
    </v-data-table>
</template>

<script>
import axios from 'axios';

export default {
    name: 'Tablefatura',
    data() {
        return {
            headers: [
                
                { title: 'id', key: 'id'},
                { title: 'Status', key: 'status'},
                { title: 'Cliente', key: 'assinatura.user.name' },
                { title: 'Descrição', key: 'descricao' },
                { title: 'Dia Vencimento', key: 'data_vencimento'},
                { title: 'Valor', key: 'valor' },
                { title: 'Ações', key: 'actions', sortable: false },
            ],
            faturas: [],
            loading: true,
            dialog: false,
            dialogDelete: false,
            editedIndex: -1,
            editedItem: {
                id: '',
                assinatura_id: '',
                descricao: '',
                data_vencimento: '',
                data_pagamento: '',
                valor: '',
                status: '',
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
            assinaturas: [],
        };
    },
    computed: {
        formTitle() {
            return this.editedIndex === -1 ? 'Nova Fatura' : 'Editar Fatura';
        },
    },
    mounted() {
        this.fetchfaturas();
        this.fetchAssinaturas();
    },
    methods: {
        fetchfaturas() {
            axios
                .get('/faturas')
                .then((response) => {
                    this.faturas = response.data;
                    this.loading = false;
                })
                .catch((error) => {
                    console.error(error);
                    this.loading = false;
                });
        },
        fetchAssinaturas() {
            axios
                .get('/assinaturas')
                .then((response) => {
                //recupera somente name e id
                    this.assinaturas = response.data;
                    this.loading = false;
                })
                .catch((error) => {
                    console.error(error);
                    this.loading = false;
                });
        },
        async savefatura() {
            axios
                .post('/faturas', {
                    ...this.editedItem,
                })
                .then((response) => {
                    this.message = `Fatura de ${response.data.assinatura.user.name} cadastrada com sucesso!`;
                    this.faturas.push(response.data);
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
        async updatefatura() {
            axios
                .put(`/faturas/${this.editedItem.id}`, {
                    ...this.editedItem,
                })
                .then((response) => {
                    this.message = `Fatura de ${response.data.assinatura.user.name} atualizada com sucesso!`;
                    this.faturas[this.editedIndex] = response.data;
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
            this.editedIndex = this.faturas.indexOf(item);
            this.editedItem = Object.assign({}, item);            
            this.dialog = true;
        },
        deleteItemConfirm() {
            let cliente = this.editedItem.assinatura.user.name;
            axios
                .delete(`/faturas/${this.editedItem.id}`)
                .then((response) => {
                    this.message = `Fatura  de ${cliente} excluída com sucesso!`;
                    this.typemessage = 'success';                                        
                })
                .catch((error) => {
                    console.error(error);
                    this.message = error.response.data.message;
                    this.typemessage = 'error';
                    this.loading = false;
                });
            this.faturas.splice(this.editedIndex, 1);
            this.closeDelete();
        },
        deleteItem(item) {
            this.editedIndex = this.faturas.indexOf(item);
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
                subtitle: item.descricao + " - R$" + item.valor,
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
