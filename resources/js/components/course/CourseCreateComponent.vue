<template>
  <v-container>
    <v-row>
      <v-col>
        <v-card>
          <v-card-title>Create Course</v-card-title>
          <v-card-text>
            <v-container>
              <v-row>
                <v-col cols="12">
                  <v-text-field
                    dense
                    v-model="course.name"
                    label="Name"
                    :error-messages="errors.name"
                  ></v-text-field>
                </v-col>

                <v-col cols="12">
                  <v-textarea
                    dense
                    v-model="course.desc"
                    label="Description"
                    :error-messages="errors.desc"
                  ></v-textarea>
                </v-col>

                <v-col cols="6">
                  <v-checkbox
                    dense
                    v-model="course.is_premium"
                    label="Premium"
                    color="orange"
                    :error-messages="errors.is_premium"
                  ></v-checkbox>
                </v-col>

                <v-col cols="6">
                  <v-text-field
                    dense
                    v-model="course.price"
                    type="number"
                    label="Price"
                    v-bind:disabled="!course.is_premium"
                    :error-messages="errors.price"
                  ></v-text-field>
                </v-col>

                <v-col cols="6">
                  <v-select
                    item-text="name"
                    item-value="id"
                    error-count="2"
                    v-model="course.course_type_id"
                    :items="options.course_types"
                    label="Course Type"
                    :error-messages="errors.course_type_id"
                  ></v-select>
                </v-col>

                <v-col cols="6">
                  <v-select
                    item-text="name"
                    item-value="id"
                    error-count="2"
                    v-model="course.grade_id"
                    :items="options.grades"
                    label="Grade"
                    :error-messages="errors.grade_id"
                  ></v-select>
                </v-col>
              </v-row>

              <v-btn block @click="store()" color="green">Create</v-btn>
            </v-container>
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
      options: [],
      errors: [],
      message: "",
      course: {
        name: "",
        desc: "",
        course_type_id: "",
        is_premium: 0,
        price: 0,
        grade_id: "",
      },
    };
  },
  mounted() {
    console.log("crouse create");
    this.init();
  },
  methods: {
    init() {
      axios.get(`${this.$baseUrl}/api/options`).then((response) => {
        this.options = response.data;
        console.log("OPTIONS", this.options);
      });
    },

    store() {
      axios
        .post(`${this.$baseUrl}/api/course`, this.course)
        .then((result) => {
          this.$router.push({
            name: "course.edit",
            params: { course_id: result.data.data.id },
          });
          this.errors = [];
        })
        .catch((err) => {
          this.errors = err.response.data.errors;
        });
    },
  },
};
</script>