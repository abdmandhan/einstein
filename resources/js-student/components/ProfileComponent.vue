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
        <v-tab>
          <v-icon left> mdi-book-check </v-icon>
          Your Courses
        </v-tab>
        <v-tab>
          <v-icon left> mdi-cart </v-icon>
          Your Transaction
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
          <v-card flat>
            <v-card-text>
              <v-container class="d-flex flex-wrap">
                <v-row>
                  <v-col v-for="(course, i) in courses" :key="i" cols="12">
                    <v-card elevation="elevation-2">
                      <v-card-title>{{ course.name }}</v-card-title>
                    </v-card>
                  </v-col>
                </v-row>
              </v-container>
            </v-card-text>
          </v-card>
        </v-tab-item>
        <v-tab-item>
          <v-card flat>
            <v-card-text>
              <v-container class="d-flex flex-wrap">
                <v-row>
                  <v-data-table
                    :headers="headers"
                    :items="transactions"
                    class="elevation-1"
                  >
                    <template v-slot:item.transaction_status_id="{ item }">
                      <v-chip :color="item.transaction_status.color">
                        {{ item.transaction_status.name }}
                      </v-chip>
                    </template>
                    <template v-slot:item.course_id="{ item }">
                      {{ item.course.name }}
                    </template>
                    <template v-slot:item.action="{ item }">
                      <v-dialog v-model="dialog[item.id]">
                        <template v-slot:activator="{ on, attrs }">
                          <v-btn
                            color="primary"
                            small
                            @click.stop="$set(dialog, item.id, true)"
                          >
                            Detail
                          </v-btn>
                        </template>

                        <v-card>
                          <v-card-title class="headline grey lighten-2">
                            Detail Transaction
                          </v-card-title>

                          <v-card-text class="mt-5">
                            <v-simple-table>
                              <template v-slot:default>
                                <tbody>
                                  <tr>
                                    <td>Course</td>
                                    <td>{{ item.course.name }}</td>
                                  </tr>
                                  <tr>
                                    <td>Status Transaction</td>
                                    <td>
                                      <v-chip
                                        :color="item.transaction_status.color"
                                      >
                                        {{ item.transaction_status.name }}
                                      </v-chip>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td>Transaction Date</td>
                                    <td>{{ item.transaction_date }}</td>
                                  </tr>
                                  <tr>
                                    <td>Amount</td>
                                    <td>{{ item.amount }}</td>
                                  </tr>
                                  <tr>
                                    <td>Transanstion Proof</td>
                                    <td>
                                      <v-img
                                        max-height="150"
                                        max-width="250"
                                        :src="photo(item.image)"
                                      ></v-img>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td>Account Number</td>
                                    <td>{{ item.account_no }}</td>
                                  </tr>
                                  <tr>
                                    <td>Account Name</td>
                                    <td>{{ item.account_name }}</td>
                                  </tr>
                                </tbody>
                              </template>
                            </v-simple-table>
                          </v-card-text>

                          <v-divider></v-divider>

                          <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn
                              color="primary"
                              text
                              @click.stop="$set(dialog, item.id, false)"
                            >
                              Close
                            </v-btn>
                          </v-card-actions>
                        </v-card>
                      </v-dialog>
                    </template>
                  </v-data-table>
                </v-row>
              </v-container>
            </v-card-text>
          </v-card>
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