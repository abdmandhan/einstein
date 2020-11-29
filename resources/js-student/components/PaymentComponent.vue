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
        <v-alert type="success" transition="slide-x-transition">
          Berhasil membeli course
        </v-alert>
        <v-card>
          <v-card-text>
            <v-simple-table>
              <template v-slot:default>
                <tbody>
                  <tr>
                    <td>Course Type</td>
                    <td>
                      {{ transaction.id }}
                    </td>
                  </tr>
                </tbody>
              </template>
            </v-simple-table>
            {{ transaction }}
          </v-card-text>
        </v-card>
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
        this.transaction = result.data.data;
        this.loading = false;
        console.log("result", this.transaction);
      })
      .catch((err) => {});
  },
};
</script>