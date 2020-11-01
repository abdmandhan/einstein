<template>
  <div>
    <v-container>
      <v-row v-if="loading">
        <v-col v-for="(a, i) in 2" :key="i" cols="6">
          <v-skeleton-loader type="article, actions"></v-skeleton-loader>
        </v-col>
      </v-row>
      <v-row v-else>
        <v-col cols="6">
          <v-card class="mx-auto">
            <v-card-subtitle class="d-flex justify-space-between">
              <span>Course Detail</span>
              <v-spacer></v-spacer>
              <span v-if="course.is_premium">
                <v-chip color="orange" text-color="white">
                  Premium
                  <v-icon right> mdi-star </v-icon>
                </v-chip>
              </span>
              <span v-else>
                <v-chip color="success" text-color="white">
                  Free
                  <v-icon right> mdi-shield-check </v-icon>
                </v-chip>
              </span>
            </v-card-subtitle>
            <v-card-text>
              <v-simple-table>
                <template v-slot:default>
                  <tbody>
                    <tr>
                      <td>Course Type</td>
                      <td>
                        {{ course.course_type.name }}
                      </td>
                    </tr>
                    <tr>
                      <td>Course Grade</td>
                      <td>{{ course.grade.name }}</td>
                    </tr>
                    <tr>
                      <td>Course Name</td>
                      <td>{{ course.name }}</td>
                    </tr>
                    <tr>
                      <td>Course Description</td>
                      <td>{{ course.desc }}</td>
                    </tr>
                    <tr>
                      <td>Price</td>
                      <td v-if="course.is_premium">{{ course.price }}</td>
                      <td v-else>FREE</td>
                    </tr>
                  </tbody>
                </template>
              </v-simple-table>

              <v-divider></v-divider>
              Teacher
              <v-simple-table>
                <template v-slot:default>
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Phone</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(teacher, i) in course.course_teacher" :key="i">
                      <td>
                        {{ teacher.teacher.name }}
                      </td>
                      <td>
                        {{ teacher.teacher.email }}
                      </td>
                      <td>
                        {{ teacher.teacher.phone }}
                      </td>
                    </tr>
                  </tbody>
                </template>
              </v-simple-table>

              <v-divider></v-divider>
              Course Content
              <v-row justify="center">
                <v-expansion-panels accordion>
                  <v-expansion-panel
                    v-for="(content, i) in course.course_content"
                    :key="i"
                  >
                    <v-expansion-panel-header>
                      {{ content.name }}
                    </v-expansion-panel-header>
                    <v-expansion-panel-content>
                      <h5>{{ content.desc }}</h5>
                      <h6>{{ content.content }}</h6>
                    </v-expansion-panel-content>
                  </v-expansion-panel>
                </v-expansion-panels>
              </v-row>
            </v-card-text>
          </v-card>
        </v-col>
        <v-col cols="6">
          <v-card class="mx-auto">
            <v-card-subtitle>Payment</v-card-subtitle>
            <v-card-text>
              <v-row>
                <v-col cols="12">
                  <v-file-input
                    dense
                    v-model="transaction.image"
                    label="Bukti Transfer"
                    :error-messages="errors.image"
                    accept="image/*"
                  ></v-file-input>
                </v-col>
                <v-col cols="6">
                  <v-text-field
                    dense
                    v-model="transaction.account_name"
                    label="Bank Account Name"
                    :error-messages="errors.account_name"
                  ></v-text-field>
                </v-col>
                <v-col cols="6">
                  <v-text-field
                    dense
                    v-model="transaction.account_no"
                    label="Bank Account Number"
                    :error-messages="errors.account_no"
                  ></v-text-field>
                </v-col>
              </v-row>
            </v-card-text>
            <v-card-actions>
              <v-btn color="primary" @click="buy" :loading="btnLoading">
                Buy
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>

<script>
export default {
  data() {
    return {
      course: {},
      loading: true,
      btnLoading: false,
      errors: [],
      transaction: {
        course_id: this.$route.params.id,
        image: {},
        account_no: "",
        account_name: "",
      },
    };
  },
  mounted() {
    axios
      .get(`${this.$baseUrl}/api/s/course/${this.$route.params.id}`)
      .then((result) => {
        this.course = result.data.data.data;
        this.loading = false;
        console.log("result", this.course);
      })
      .catch((err) => {});
  },
  methods: {
    buy() {
      this.btnLoading = true;
      axios
        .post(`${this.$baseUrl}/api/s/course`, this.transaction)
        .then((result) => {
          console.log("RESULT", result);
          this.btnLoading = false;
          this.errors = [];
        })
        .catch((err) => {
          this.errors = err.response.data.errors;
          this.btnLoading = false;
        });
    },
  },
};
</script>