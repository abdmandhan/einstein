<template>
  <div>
    <v-container class="d-flex flex-wrap">
      <v-row justify="center">
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
                            <v-chip :color="item.transaction_status.color">
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
                            <v-dialog v-model="dialogPreview[item.id]">
                              <template v-slot:activator="{ on, attrs }">
                                <v-img
                                  max-height="150"
                                  max-width="250"
                                  dark
                                  @click.stop="
                                    $set(dialogPreview, item.id, true)
                                  "
                                  :src="photo(item.image)"
                                  :lazy-src="photo('/storage/other/blur.jpg')"
                                >
                                </v-img>
                              </template>

                              <v-card>
                                <v-card-title class="headline grey lighten-2">
                                  Bukti Transfer
                                </v-card-title>

                                <v-card-text>
                                  <v-img
                                    dark
                                    :src="photo(item.image)"
                                    :lazy-src="photo('/storage/other/blur.jpg')"
                                  ></v-img>
                                </v-card-text>

                                <v-divider></v-divider>

                                <v-card-actions>
                                  <v-spacer></v-spacer>
                                  <v-btn
                                    color="primary"
                                    text
                                    @click.stop="
                                      $set(dialogPreview, item.id, false)
                                    "
                                  >
                                    Close
                                  </v-btn>
                                </v-card-actions>
                              </v-card>
                            </v-dialog>
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
  </div>
</template>


<script>
export default {
  props: {
    transactions: {
      type: Array,
    },
  },
  data: () => ({
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
    dialog: {},
    dialogPreview: {},
  }),
  mounted() {},
  methods: {
    photo(name) {
      return `${this.$baseUrl}/${name}`;
    },
  },
};
</script>