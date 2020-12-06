<template>
  <v-container class="d-flex flex-wrap">
    <skeleton-loader-component v-if="loading" :count="6" />
    <v-container v-else>
      <v-container>
        <v-row>
          <v-col cols="12">
            <v-row justify="center">
              <v-dialog v-model="dialog" persistent max-width="600px">
                <template v-slot:activator="{ on, attrs }">
                  <v-btn color="primary" dark v-bind="attrs" v-on="on">
                    Create Discuss
                  </v-btn>
                </template>
                <v-card>
                  <v-card-title>
                    <span class="headline">Create Discussion</span>
                  </v-card-title>
                  <v-card-text>
                    <v-container>
                      <v-row>
                        <v-col cols="12">
                          <v-textarea
                            label="Text"
                            required
                            v-model="form.text"
                            :error-messages="errors.text"
                          ></v-textarea>
                        </v-col>
                        <v-col cols="12">
                          <v-select
                            item-value="id"
                            item-text="name"
                            :items="options.course_types"
                            label="Category"
                            outlined
                            v-model="form.course_type_id"
                            required
                            :error-messages="errors.course_type_id"
                          ></v-select>
                        </v-col>
                      </v-row>
                    </v-container>
                  </v-card-text>
                  <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" text @click="dialog = false">
                      Close
                    </v-btn>
                    <v-btn color="blue darken-1" text @click="createDiscuss()">
                      Save
                    </v-btn>
                  </v-card-actions>
                </v-card>
              </v-dialog>
            </v-row>
          </v-col>
          <v-col cols="3">
            <v-select
              item-value="id"
              item-text="name"
              :items="options.course_types"
              label="Category"
              outlined
              v-model="filter.category"
            ></v-select>
          </v-col>
          <v-col cols="3">
            <v-select
              item-value="id"
              item-text="name"
              :items="status"
              label="Status"
              outlined
              v-model="filter.status"
            ></v-select>
          </v-col>
          <v-col cols="3">
            <v-select
              item-value="id"
              item-text="name"
              :items="my"
              label="My Discussion"
              outlined
              v-model="filter.my"
            ></v-select>
          </v-col>
          <v-col cols="3">
            <v-select
              item-value="id"
              item-text="name"
              :items="order"
              label="Order"
              outlined
              v-model="filter.order"
            ></v-select>
          </v-col>
        </v-row>
      </v-container>
      <discuss-card-component :discuss="discuss" @refresh="init()" />
      <v-pagination
        v-model="filter.page"
        :length="length"
        circle
        :total-visible="10"
      ></v-pagination>
    </v-container>
  </v-container>
</template>

<script>
export default {
  data() {
    return {
      dialog: false,
      filter: {
        category: null,
        status: null,
        order: "desc",
        page: 1,
        my: null,
      },
      status: [
        {
          id: "DONE",
          name: "DONE",
        },
        {
          id: "DOING",
          name: "DOING",
        },
      ],
      order: [
        {
          id: "asc",
          name: "LAST",
        },
        {
          id: "desc",
          name: "NEW",
        },
      ],
      my: [
        {
          id: 1,
          name: "YES",
        },
        {
          id: 0,
          name: "NO",
        },
      ],
      options: {},
      discuss: [],
      loading: true,
      length: 0,
      form: {
        text: "",
        course_type_id: "",
      },
      errors: [],
    };
  },
  mounted() {
    axios.get(`${this.$baseUrl}/api/options`).then((response) => {
      this.options = response.data;
    });

    this.init();
  },
  watch: {
    filter: {
      handler() {
        this.loading = true;
        this.discuss = [];
        this.init();
      },
      deep: true,
    },
  },
  methods: {
    init() {
      this.loading = true;
      axios
        .get(`${this.$baseUrl}/api/discuss`, { params: this.filter })
        .then((result) => {
          this.discuss = result.data.data.data;
          if (this.length != result.data.data.last_page) {
            this.filter.page = 1;
          }
          this.length = result.data.data.last_page;
          this.loading = false;
          console.log("RESPONSE", result);
        })
        .catch((err) => {});
    },
    createDiscuss() {
      axios
        .post(`${this.$baseUrl}/api/discuss`, this.form)
        .then((result) => {
          this.errors = [];
          this.dialog = false;
          this.init();
          console.log("RESULT", result);
        })
        .catch((err) => {
          this.errors = err.response.data.errors;
        });
    },
  },
};
</script>
