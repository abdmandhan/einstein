<template>
  <v-container>
    <v-row>
      <v-col v-if="loading" cols="3" v-for="(a, i) in 12" :key="i">
        <v-skeleton-loader type="article, actions"></v-skeleton-loader>
      </v-col>
      <v-col cols="3" v-for="(course, i) in courses" :key="i">
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