<template>
  <v-container>
    <v-row>
      <v-col>
        <v-card>
          <v-card-title>Edit Course</v-card-title>
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

              <v-card>
                <v-tabs v-model="tab" background-color="primary" dark>
                  <v-tab> Course Content </v-tab>
                  <v-tab> Course Task </v-tab>
                </v-tabs>

                <v-tabs-items v-model="tab">
                  <v-tab-item>
                    <v-card flat>
                      <course-table-component
                        :key="Math.random()"
                        nameTable="Course Content"
                        :dataParent="course"
                        :relationKey="relationKey"
                        :api="api.course_content"
                      />
                    </v-card>
                  </v-tab-item>
                  <v-tab-item>
                    <v-card flat>
                      <course-table-component
                        :key="Math.random()"
                        nameTable="Course Task"
                        :dataParent="course"
                        :relationKey="relationKey"
                        :api="api.course_task"
                      />
                    </v-card>
                  </v-tab-item>
                </v-tabs-items>
              </v-card>

              <v-btn block @click="store()" color="green">Save</v-btn>
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
      tab: null,
      loading: true,
      relationKey: "",
      api: {},

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
    console.log("crouse edit");
    this.init();
  },
  methods: {
    init() {
      axios.get(`${this.$baseUrl}/api/options`).then((response) => {
        this.options = response.data;
      });

      axios
        .get(`${this.$baseUrl}/api/course/${this.$route.params.course_id}/edit`)
        .then((response) => {
          this.course = response.data.data.course;
          this.api = response.data.data.api;
          this.relationKey = response.data.data.relation_key;
          console.log("response", this.course);
        });
    },
  },
};
</script>