<template>
  <v-card class="p-2">
    <v-card-title> {{ course.name }} </v-card-title>

    <v-card-subtitle>
      {{ course.course_type.name }} - Grade
      {{ course.grade.name }}</v-card-subtitle
    >
    <div class="d-flex justify-space-between" v-if="course.is_premium">
      <v-chip class="ma-2" color="orange" text-color="white">
        Premium
        <v-icon right> mdi-star </v-icon>
      </v-chip>
      <span class="ma-4"> Rp {{ course.price }} </span>
    </div>
    <v-chip class="ma-2" color="success" text-color="white" v-else>
      Free
      <v-icon right> mdi-shield-check </v-icon>
    </v-chip>
    <v-card-actions>
      <v-btn
        color="primary lighten-2"
        :to="{ name: 'course-join', params: { id: course.id } }"
      >
        Join this Course
      </v-btn>

      <v-spacer></v-spacer>

      <v-btn icon @click="show = !show">
        <v-icon>{{ show ? "mdi-chevron-up" : "mdi-chevron-down" }}</v-icon>
      </v-btn>
    </v-card-actions>

    <v-expand-transition>
      <div v-show="show">
        <v-divider></v-divider>

        <v-card-text>
          <div>{{ course.desc }}</div>
          <v-sheet elevation="10" rounded="xl" class="pa-2 mt-5">
            <div class="text-center"><strong>Teacher</strong></div>
            <div
              v-for="(teacher, i) in course.course_teacher"
              :key="i"
              class="mb-5"
            >
              <v-avatar class="mr-4">
                <img
                  src="https://cdn.vuetifyjs.com/images/john.jpg"
                  alt="John"
                />
              </v-avatar>
              {{ teacher.teacher.name }}
            </div>
          </v-sheet>
        </v-card-text>
      </div>
    </v-expand-transition>
  </v-card>
</template>

<script>
export default {
  data: () => ({
    show: false,
  }),
  props: {
    course: {
      type: Object,
    },
  },
};
</script>