<template>
  <v-container class="d-flex flex-wrap">
    <v-row>
      <v-col v-if="loading" v-for="(a, i) in 12" :key="i" cols="4">
        <v-skeleton-loader type="article, actions"></v-skeleton-loader>
      </v-col>
      <v-col v-for="(teacher, i) in teachers" :key="i" cols="4">
        <teacher-card-component :teacher="teacher" />
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {
  data: () => ({
    teachers: [],
    loading: true,
  }),
  mounted() {
    axios
      .get(`${this.$baseUrl}/api/s/teacher`)
      .then((result) => {
        this.teachers = result.data.data.teachers;
        this.loading = false;
      })
      .catch((err) => {});
  },
};
</script>