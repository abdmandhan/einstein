<template>
  <div>
    <skeleton-loader-component v-if="loading" :count="6" />
    <div v-else>
      <v-container>
        <v-row>
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
      <discuss-card-component :discuss="discuss" />
      <v-pagination
        v-model="filter.page"
        :length="length"
        circle
      ></v-pagination>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      filter: {
        category: null,
        status: null,
        order: "asc",
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
  },
};
</script>
