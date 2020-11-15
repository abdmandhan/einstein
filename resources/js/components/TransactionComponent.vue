<template>
  <v-data-table
    :headers="headers"
    :items="users"
    class="elevation-1"
    :loading="loading"
  >
    <template v-slot:top>
      <v-toolbar flat>
        <v-toolbar-title>Transaction</v-toolbar-title>
        <v-spacer></v-spacer>
        <v-dialog v-model="dialog">
          <v-card>
            <v-card-title>
              <span class="headline">Edit Transaction</span>
            </v-card-title>

            <v-card-text>
              <v-container>
                <v-row>
                  <v-col cols="6">
                    <v-text-field
                      dense
                      v-model="editedItem.id"
                      label="ID"
                      :error-messages="errors.id"
                      disabled
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
    <template v-slot:[`item.course_id`]="{ item }">
      {{ item.course.name }}
    </template>
    <template v-slot:[`item.transaction_status_id`]="{ item }">
      <v-chip :color="item.transaction_status.color">
        {{ item.transaction_status.name }}
      </v-chip>
    </template>
    <template v-slot:[`item.image`]="{ item }">
      <v-img max-height="150" max-width="250" :src="photo(item.image)"></v-img>
    </template>
    <template v-slot:[`item.actions`]="{ item }">
      <span v-if="item.transaction_status_id != 2">
        <v-btn color="primary" small> Accept </v-btn>
        <v-btn color="danger" small> Reject </v-btn>
      </span>
      <!-- <v-icon small class="mr-2" @click="editItem(item)"> mdi-pencil </v-icon>
      <v-icon small @click="deleteItem(item)"> mdi-delete </v-icon> -->
    </template>
    <template v-slot:[`item.is_premium`]="{ item }">
      <v-chip v-bind:color="item.is_premium ? 'warning' : 'success'">{{
        item.is_premium ? "Premium" : "Free"
      }}</v-chip>
    </template>
    <template v-slot:no-data>
      <v-btn color="primary" @click="initialize"> Reset </v-btn>
    </template>
  </v-data-table>
</template>

<script>
export default {
  data: () => ({
    tab: null,

    loading: true,
    dialog: false,
    dialogDelete: false,

    options: [],

    headers: [],
    relationKey: "",
    api: {},
    users: [],
    errors: [],
    message: "",

    editedIndex: -1,
    editedItem: {
      id: "",
    },
    defaultItem: {
      id: "",
    },
  }),

  watch: {
    dialog(val) {
      val || this.close();
    },
    dialogDelete(val) {
      val || this.closeDelete();
    },
    "editedItem.is_premium": function (newVal, oldVal) {
      if (!newVal) this.editedItem.price = null;
    },
  },

  created() {
    this.initialize();
  },

  methods: {
    photo(name) {
      if (name) {
        return `${this.$baseUrl}/${name}`;
      } else {
        return `${this.$baseUrl}/storage/other/notfound.jpg`;
      }
    },
    initialize() {
      axios.get(`${this.$baseUrl}/api/options`).then((response) => {
        this.options = response.data;
        console.log("OPTIONS", this.options);
      });

      axios.get(`${this.$baseUrl}/api/transaction`).then((response) => {
        this.users = response.data.data.data;
        this.headers = response.data.data.header;
        this.relationKey = response.data.data.relation_key;
        this.api = response.data.data.api;
        this.loading = false;
      });
    },

    editItem(item) {
      this.editedIndex = this.users.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialog = true;
    },

    deleteItem(item) {
      this.editedIndex = this.users.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialogDelete = true;
    },

    deleteItemConfirm() {
      axios
        .delete(`${this.$baseUrl}/api/course/${this.editedItem.id}`)
        .then((result) => {
          this.initialize();
        });

      this.closeDelete();
    },

    close() {
      this.message = "";
      this.errors = [];
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

    save() {
      console.log("EDITED ITEM", this.editedItem);
      axios
        .post(`${this.$baseUrl}/api/course`, this.editedItem)
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