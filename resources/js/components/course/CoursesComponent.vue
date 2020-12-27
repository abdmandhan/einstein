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
        <v-btn
          color="primary"
          dark
          class="mb-2"
          :to="{ name: 'course.create' }"
        >
          New Course
        </v-btn>
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
      <v-icon small class="mr-2" @click="edit(item)"> mdi-pencil </v-icon>
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
    loading: true,
    dialogDelete: false,

    options: [],

    headers: [],
    users: [],
    errors: [],
    message: "",

    deleteIndex: null,
  }),

  computed: {},

  watch: {
    dialogDelete(val) {
      val || this.closeDelete();
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
        this.loading = false;
      });
    },

    deleteItem(item) {
      this.dialogDelete = true;
      this.deleteIndex = item.id;
      console.log("delete item", item);
    },

    deleteItemConfirm() {
      axios
        .delete(`${this.$baseUrl}/api/course/${this.deleteIndex}`)
        .then((result) => {
          this.initialize();
        });

      this.closeDelete();
    },

    closeDelete() {
      this.dialogDelete = false;
      this.$nextTick(() => {
        this.deleteIndex = null;
      });
    },
    edit(item) {
      this.$router.push({
        name: "course.edit",
        params: { course_id: item.id },
      });
      console.log("item", item);
    },
  },
};
</script>