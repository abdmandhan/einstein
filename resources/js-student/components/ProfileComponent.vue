<template>
  <v-container>
    <v-sheet rounded="lg">
      <v-alert v-if="message" type="success">
        {{ message }}
      </v-alert>
      <v-tabs vertical>
        <v-tab>
          <v-icon left> mdi-account </v-icon>
          Profile
        </v-tab>
        <v-tab>
          <v-icon left> mdi-lock </v-icon>
          Change Password
        </v-tab>

        <v-tab-item>
          <v-card flat :loading="loading">
            <v-card-text>
              <span v-if="loading">Loading..</span>
              <v-container v-else>
                <v-row>
                  <v-col cols="12">
                    <v-avatar class="profile" color="grey" size="164" tile>
                      <v-img :src="photo(user.photo)"></v-img>
                    </v-avatar>
                    <!-- <v-text-field
                      dense
                      v-model="user.photo"
                      label="Photo"
                      :error-messages="errors.photo"
                      disabled
                    ></v-text-field> -->
                  </v-col>
                  <v-col cols="6">
                    <v-text-field
                      dense
                      v-model="user.id"
                      label="ID"
                      :error-messages="errors.id"
                      disabled
                    ></v-text-field>
                  </v-col>

                  <v-col cols="6">
                    <v-text-field
                      dense
                      v-model="user.user_student.grade.name"
                      label="Grade"
                      :error-messages="errors.id"
                      disabled
                    ></v-text-field>
                  </v-col>

                  <v-col cols="6">
                    <v-text-field
                      dense
                      v-model="user.email"
                      label="Email"
                      error-count="2"
                      :error-messages="errors.email"
                    ></v-text-field>
                  </v-col>

                  <v-col cols="6">
                    <v-text-field
                      dense
                      v-model="user.name"
                      label="Name"
                      :error-messages="errors.name"
                    ></v-text-field>
                  </v-col>

                  <v-col cols="6">
                    <v-text-field
                      dense
                      v-model="user.phone"
                      type="number"
                      label="Phone"
                      :error-messages="errors.phone"
                    ></v-text-field>
                  </v-col>

                  <v-col cols="12">
                    <v-textarea
                      v-model="user.address"
                      label="Address"
                      :error-messages="errors.address"
                    ></v-textarea>
                  </v-col>
                </v-row>
                <v-row>
                  <v-btn color="primary" @click="save"> Save </v-btn>
                </v-row>
              </v-container>
            </v-card-text>
          </v-card>
        </v-tab-item>
        <v-tab-item>
          <v-card flat>
            <v-card-text>
              <v-container>
                <v-row>
                  <v-col cols="12">
                    <v-text-field
                      dense
                      v-model="cPassword.old_password"
                      label="Old Password"
                      type="password"
                      :error-messages="errors.old_password"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12">
                    <v-text-field
                      dense
                      v-model="cPassword.new_password"
                      label="New Password"
                      type="password"
                      :error-messages="errors.new_password"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12">
                    <v-text-field
                      dense
                      v-model="cPassword.new_password_confirmation"
                      label="Confirmation New Password"
                      type="password"
                      :error-messages="errors.new_password_confirmation"
                    ></v-text-field>
                  </v-col>
                </v-row>
                <v-row>
                  <v-btn color="primary" @click="changePassword">
                    Change Password
                  </v-btn>
                </v-row>
              </v-container>
            </v-card-text>
          </v-card>
        </v-tab-item>
        <v-tab-item>
          <student-course-card-component :courses="courses" />
        </v-tab-item>
      </v-tabs>
    </v-sheet>
  </v-container>
</template>

<script>
export default {
  data: () => ({
    user: {
      id: "",
      name: "",
      email: "",
      address: "",
      phone: "",
    },
    cPassword: {
      old_password: "",
      new_password: "",
      new_password_confirmation: "",
    },
    errors: [],
    loading: true,
    message: "",
    courses: [],
    headers: [
      { text: "ID", value: "id" },
      { text: "Course", value: "course_id" },
      { text: "Status", value: "transaction_status_id" },
      { text: "Date", value: "transaction_date" },
      { text: "Amount", value: "amount" },
      { text: "Action", value: "action" },
    ],
    transactions: [],
    dialog: {},
  }),
  mounted() {
    axios.get(`${this.$baseUrl}/api/student`).then((result) => {
      this.user = result.data.data.user;
      this.courses = result.data.data.courses;
      this.transactions = result.data.data.transactions;
      console.log("courses", this.courses);
      this.loading = false;
    });
  },
  methods: {
    photo(name) {
      return `${this.$baseUrl}/${name}`;
    },
    save() {
      axios
        .post(`${this.$baseUrl}/api/student`, this.user)
        .then((result) => {
          this.errors = [];
          this.message = "Success save profile";
        })
        .catch((err) => {
          this.message = "";
          this.errors = err.response.data.errors;
        });
    },
    changePassword() {
      axios
        .put(`${this.$baseUrl}/api/student/${this.user.id}`, this.cPassword)
        .then((result) => {
          console.log("RESULSTEDF", result);
          this.errors = [];
          this.message = "Success change password";
        })
        .catch((err) => {
          this.message = "";
          this.errors = err.response.data.errors;
          console.log("ERRORS", this.errors);
        });
    },
  },
};
</script>