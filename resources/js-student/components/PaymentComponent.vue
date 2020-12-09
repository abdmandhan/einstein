<template>
  <div>
    <v-skeleton-loader
      class="mx-auto"
      max-width="300"
      type="card"
      v-if="loading"
    />
    <v-container v-else>
      <v-row justify="center">
        <v-col cols="12">
          <v-alert type="success" transition="slide-x-transition">
            Berhasil membeli course
          </v-alert>
        </v-col>
        <v-col cols="12">
          <v-card>
            <v-card-text>
              <v-simple-table>
                <template v-slot:default>
                  <tbody>
                    <tr>
                      <td>Course Name</td>
                      <td>
                        {{ transaction.course.name }}
                      </td>
                    </tr>
                    <tr>
                      <td>Course Type</td>
                      <td>
                        {{ transaction.course.course_type.name }}
                      </td>
                    </tr>
                    <tr>
                      <td>Status</td>
                      <td>
                        {{ transaction.transaction_status.name }}
                      </td>
                    </tr>
                  </tbody>
                </template>
              </v-simple-table>
            </v-card-text>
          </v-card>
        </v-col>
        <v-col cols="12">
          <v-btn :to="{ name: 'dashboard.transaction' }"
            >List of Transaction</v-btn
          >
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>

<script>
export default {
  data() {
    return {
      transaction: {},
      loading: true,
    };
  },
  mounted() {
    axios
      .get(`${this.$baseUrl}/api/s/payment/${this.$route.params.id}`)
      .then((result) => {
        console.log("RESULT", result);
        if (result.data.status) {
          this.transaction = result.data.data;
          this.loading = false;
        } else {
          this.$router.push({ name: "dashboard.learning" });
        }
        console.log("result", this.transaction);
      })
      .catch((err) => {});
  },
};
</script>