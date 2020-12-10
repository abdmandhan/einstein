<template>
  <v-container>
    <v-card v-if="learning.course">
      <v-card-title>{{ learning.course.name }}</v-card-title>
      <v-card-subtitle>{{ learning.course.course_type.name }}</v-card-subtitle>
      <v-card-text>
        <learning-content-component :learning="learning" :loading="loading" />
        <br />
        <learning-task-component :learning="learning" :loading="loading" />
      </v-card-text>
    </v-card>
  </v-container>
</template>

<script>
export default {
  data() {
    return {
      learning: {},
      loading: true,
    };
  },
  mounted() {
    axios
      .get(`${this.$baseUrl}/api/s/learning/${this.$route.params.id}`)
      .then((result) => {
        if (result.data.status) {
          this.loading = false;
          this.learning = result.data.data;
        } else {
          this.$router.push({ name: "dashboard.learning" });
        }
      })
      .catch((err) => {});
  },
};
</script>