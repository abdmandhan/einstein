<template>
  <div>
    <v-card flat>
      <v-card-text>
        <v-container class="d-flex flex-wrap">
          <v-row>
            <v-col v-for="(course, i) in courses" :key="i" cols="12">
              <v-card elevation="elevation-2">
                <v-card-title>
                  {{ course.name }}

                  <v-divider></v-divider>
                  <v-btn color="primary"> Learn Course </v-btn>
                </v-card-title>
              </v-card>
            </v-col>
          </v-row>
        </v-container>
      </v-card-text>
    </v-card>
  </div>
</template>

<script>
export default {
  props: {
    courses: {
      type: Array,
    },
  },
};
</script>