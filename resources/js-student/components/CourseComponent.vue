<template>
  <v-container class="d-flex flex-wrap">
    <v-row>
      <v-col v-if="loading" v-for="(a, i) in 12" :key="i" cols="4">
        <v-skeleton-loader type="article, actions"></v-skeleton-loader>
      </v-col>
      <v-col v-for="(course, i) in courses" :key="i" cols="4">
        <course-card-component :course="course" />
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {
  data: () => ({
    courses: [],
    loading: true,
  }),
  mounted() {
    axios
      .get(`${this.$baseUrl}/api/s/course`)
      .then((result) => {
        this.courses = result.data.data.data;
        this.loading = false;
      })
      .catch((err) => {});
  },
};
</script>