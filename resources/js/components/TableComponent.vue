<template>
  <v-data-table
    :headers="headers"
    :items="items"
    class="elevation-1"
    :loading="loading"
  >
    <template v-slot:top>
      <v-toolbar flat>
        <v-toolbar-title>{{ nameTable }}</v-toolbar-title>
        <v-spacer></v-spacer>
        <v-dialog v-model="dialog" max-width="500px">
          <template v-slot:activator="{ on, attrs }">
            <v-btn color="primary" dark class="mb-2" v-bind="attrs" v-on="on">
              New Item
            </v-btn>
          </template>
          <v-card>
            <v-card-title>
              <span class="headline">{{ formTitle }}</span>
            </v-card-title>

            <v-card-text>
              <v-container>
                <v-row>
                  <v-col cols="6" v-for="(header, i) in headers" :key="i">
                    <v-text-field
                      v-if="header.value != 'actions'"
                      v-model="form.data[header.value]"
                      :label="header.text"
                      v-bind:disabled="header.disabled"
                      :error-messages="errors[header.value]"
                    ></v-text-field>
                  </v-col>
                </v-row>
              </v-container>
            </v-card-text>

            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="close"> Cancel </v-btn>
              <v-btn color="blue darken-1" text @click="save"> Save </v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
        <v-dialog v-model="dialogDelete" max-width="500px">
          <v-card>
            <v-card-title class="headline"
              >Are you sure you want to delete this item?</v-card-title
            >
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="closeDelete"
                >Cancel</v-btn
              >
              <v-btn color="blue darken-1" text @click="deleteItemConfirm"
                >OK</v-btn
              >
              <v-spacer></v-spacer>
            </v-card-actions>
          </v-card>
        </v-dialog>
      </v-toolbar>
    </template>
    <template v-slot:item.actions="{ item }">
      <v-icon small class="mr-2" @click="editItem(item)"> mdi-pencil </v-icon>
      <v-icon small @click="deleteItem(item)"> mdi-delete </v-icon>
    </template>
    <template v-slot:no-data>
      <v-btn color="primary" @click="initialize"> Reset </v-btn>
    </template>
  </v-data-table>
</template>

<script>
export default {
  props: {
    nameTable: {
      default: "",
    },
    dataParent: {
      default: {},
    },
    relationKey: {
      default: "",
    },
    api: {
      default: {},
    },
  },
  data: () => ({
    loading: true,
    form: {
      data: [],
    },
    errors: [],
    headers: [],
    dialog: false,
    dialogDelete: false,
    items: [],
    editedIndex: -1,
  }),

  computed: {
    formTitle() {
      return this.editedIndex === -1 ? "New Item" : "Edit Item";
    },
  },

  watch: {
    dialog(val) {
      val || this.close();
    },
    dialogDelete(val) {
      val || this.closeDelete();
    },
  },

  created() {
    console.log("table HEADER", this.headers);
    this.initialize();
  },

  methods: {
    initialize() {
      axios.get(`${this.api}/${this.dataParent.id}`).then((response) => {
        this.items = response.data.data.data;
        this.headers = response.data.data.header;
        this.loading = false;
      });
    },

    editItem(item) {
      this.editedIndex = this.items.indexOf(item);
      this.form.data = Object.assign({}, item);
      this.dialog = true;
    },

    deleteItem(item) {
      this.editedIndex = this.items.indexOf(item);
      this.form.data = Object.assign({}, item);
      this.dialogDelete = true;
    },

    deleteItemConfirm() {
      axios.delete(`${this.api}/${this.form.data.id}`).then((result) => {
        this.initialize();
      });

      this.closeDelete();
    },

    close() {
      this.dialog = false;
      this.$nextTick(() => {
        this.form.data = {};
        this.editedIndex = -1;
      });
    },

    closeDelete() {
      this.dialogDelete = false;
      this.$nextTick(() => {
        this.form.data = {};
        this.editedIndex = -1;
      });
    },

    save() {
      axios
        .post(`${this.api}`, {
          ...this.form.data,
          [this.relationKey]: this.dataParent.id,
        })
        .then((response) => {
          this.initialize();
          this.close();
          console.log("Response", response);
        })
        .catch((error) => {
          this.message = error.response.data.message;
          this.errors = error.response.data.errors;
          console.log("ERROR", error.response, this.message, this.errors);
        });
    },
  },
};
</script>