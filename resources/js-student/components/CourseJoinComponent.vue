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
          <v-card class="mb-5">
            <v-card-title class="d-flex justify-space-between">
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
            </v-card-title>
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
            </v-card-text>
          </v-card>

          <v-card class="mb-5">
            <v-card-title> Teacher </v-card-title>
            <v-card-text>
              <v-simple-table dense>
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
            </v-card-text>
          </v-card>
        </v-col>
        <v-col cols="6">
          <v-card class="mx-auto">
            <v-card-subtitle>Payment</v-card-subtitle>
            <v-card-text v-if="course.is_premium">
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
      let formData = new FormData();

      for (const key in this.transaction) {
        formData.append(key, this.transaction[key]);
      }

      console.log("formData", formData);

      axios
        .post(`${this.$baseUrl}/api/s/course`, formData, {
          headers: {
            Accept: "application/json",
            "Content-Type": "multipart/form-data",
          },
        })
        .then((result) => {
          console.log("RESULT", result);
          this.btnLoading = false;
          this.errors = [];
          window.location.href = this.$baseUrl + "/student/profile";
        })
        .catch((err) => {
          this.errors = err.response.data.errors;
          this.btnLoading = false;
        });
    },
  },
  watch: {
    "transaction.image": function (newVal, oldVal) {
      console.log("IMAGE", newVal, oldVal);
    },
  },
};
</script>