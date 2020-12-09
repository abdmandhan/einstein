<template>
  <v-container>
    <v-row justify="center">
      <v-col cols="12" v-if="!loading">
        <v-alert
          color="warning"
          dark
          icon="mdi-school"
          prominent
          v-if="learnings.length == 0"
        >
          Anda belum memiliki course, silahkan beli course
          <v-btn text color="red" :to="{ name: 'dashboard.course' }"
            >disini</v-btn
          >
        </v-alert>
      </v-col>
      <v-col cols="4" v-for="(learning, i) in learnings" :key="i">
        <v-card>
          <v-card-title>
            {{ learning.course.name }}
          </v-card-title>
          <v-card-subtitle>
            {{ learning.course.course_type.name }}
            {{ learning.course.grade.name }}
            <div>
              <v-chip
                v-if="learning.is_complete"
                color="green"
                small
                text-color="white"
              >
                Complete
              </v-chip>
              <v-chip v-else color="red" small text-color="white"
                >Not Complete
              </v-chip>
            </div>
          </v-card-subtitle>
          <v-card-text>
            <v-btn
              color="primary"
              :to="{
                name: 'dashboard.learning.show',
                params: { id: learning.id },
              }"
              >Learn this course</v-btn
            >
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {
  data() {
    return {
      learnings: [],
      loading: true,
    };
  },
  mounted() {
    axios
      .get(`${this.$baseUrl}/api/s/learning`)
      .then((result) => {
        this.loading = false;
        if (result.data.status) {
          this.learnings = result.data.data;
        }
        console.log("result", result, this.learnings);
      })
      .catch((err) => {});
  },
};
</script>