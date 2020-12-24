<template>
  <v-data-table
    :headers="headers"
    :items="users"
    class="elevation-1"
    :loading="loading"
  >
    <template v-slot:top>
      <v-toolbar flat>
        <v-toolbar-title>Courses</v-toolbar-title>
        <v-spacer></v-spacer>
        <v-dialog v-model="dialog">
          <template v-slot:activator="{ on, attrs }">
            <v-btn color="primary" dark class="mb-2" v-bind="attrs" v-on="on">
              New Course
            </v-btn>
          </template>
          <v-card>
            <v-card-title>
              <span class="headline">{{ formTitle }}</span>
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

                  <v-col cols="6">
                    <v-text-field
                      dense
                      v-model="editedItem.name"
                      label="Name"
                      :error-messages="errors.name"
                    ></v-text-field>
                  </v-col>

                  <v-col cols="6">
                    <v-text-field
                      dense
                      v-model="editedItem.price"
                      type="number"
                      label="Price"
                      v-bind:disabled="!editedItem.is_premium"
                      :error-messages="errors.price"
                    ></v-text-field>
                  </v-col>

                  <v-col cols="6">
                    <v-checkbox
                      dense
                      v-model="editedItem.is_premium"
                      label="Premium"
                      color="orange"
                      :error-messages="errors.is_premium"
                    ></v-checkbox>
                  </v-col>

                  <v-col cols="6">
                    <v-select
                      item-text="name"
                      item-value="id"
                      error-count="2"
                      v-model="editedItem.course_type_id"
                      :items="options.course_types"
                      label="Course Type"
                      :error-messages="errors.course_type_id"
                    ></v-select>
                  </v-col>

                  <v-col cols="6">
                    <v-select
                      item-text="name"
                      item-value="id"
                      error-count="2"
                      v-model="editedItem.grade_id"
                      :items="options.grades"
                      label="Grade"
                      :error-messages="errors.grade_id"
                    ></v-select>
                  </v-col>
                </v-row>
                <v-card v-if="!(editedIndex === -1)">
                  <v-tabs v-model="tab" background-color="primary" dark>
                    <v-tab> Course Content </v-tab>
                    <v-tab> Course Task </v-tab>
                  </v-tabs>

                  <v-tabs-items v-model="tab">
                    <v-tab-item>
                      <v-card flat>
                        <table-component
                          :key="Math.random()"
                          nameTable="Course Content"
                          :dataParent="editedItem"
                          :relationKey="relationKey"
                          :api="api.course_content"
                        />
                      </v-card>
                    </v-tab-item>
                    <v-tab-item>
                      <v-card flat>
                        <table-component
                          :key="Math.random()"
                          nameTable="Course Task"
                          :dataParent="editedItem"
                          :relationKey="relationKey"
                          :api="api.course_task"
                        />
                      </v-card>
                    </v-tab-item>
                  </v-tabs-items>
                </v-card>
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
    <template v-slot:[`item.actions`]="{ item }">
      <v-icon small class="mr-2" @click="editItem(item)"> mdi-pencil </v-icon>
      <v-icon small @click="deleteItem(item)"> mdi-delete </v-icon>
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
      name: "",
      course_type_id: "",
      is_premium: "",
      price: 0,
      grade_id: "",
    },
    defaultItem: {
      id: "",
      name: "",
      course_type_id: "",
      is_premium: "",
      price: 0,
      grade_id: "",
    },
  }),

  computed: {
    formTitle() {
      return this.editedIndex === -1 ? "New User" : "Edit User";
    },
  },

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
    initialize() {
      axios.get(`${this.$baseUrl}/api/options`).then((response) => {
        this.options = response.data;
        console.log("OPTIONS", this.options);
      });

      axios.get(`${this.$baseUrl}/api/course`).then((response) => {
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