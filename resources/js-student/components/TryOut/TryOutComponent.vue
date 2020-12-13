<template>
  <v-container>
    <v-row>
      <v-col cols="6" v-for="(item, index) in tryouts" :key="index">
        <v-card>
          <v-card-title>{{ item.name }}</v-card-title>
          <v-card-subtitle>
            <v-chip :color="item.difficulty.color" small>
              {{ item.difficulty.name }}
            </v-chip>
          </v-card-subtitle>
          <v-card-text>
            <v-simple-table>
              <template v-slot:default>
                <tbody>
                  <tr>
                    <td>Start Date</td>
                    <td>{{ item.date_start }}</td>
                  </tr>
                  <tr>
                    <td>Finish Date</td>
                    <td>{{ item.date_finish }}</td>
                  </tr>
                  <tr>
                    <td>Waktu Mengerjakan</td>
                    <td>{{ item.time }}</td>
                  </tr>
                  <tr>
                    <td>Jumlah Soal</td>
                    <td>{{ item.question_count }}</td>
                  </tr>
                </tbody>
              </template>
            </v-simple-table>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-dialog v-model="dialog[item.id]" persistent max-width="500">
              <template v-slot:activator="{ on, attrs }">
                <v-btn color="primary" dark v-bind="attrs" v-on="on">
                  Kerjakan
                </v-btn>
              </template>
              <v-card>
                <v-card-title class="headline">
                  {{ item.name }}
                </v-card-title>
                <v-card-text>
                  <v-simple-table>
                    <template v-slot:default>
                      <tbody>
                        <tr>
                          <td>Start Date</td>
                          <td>:</td>
                          <td>{{ item.date_start }}</td>
                        </tr>
                        <tr>
                          <td>Finish Date</td>
                          <td>:</td>
                          <td>{{ item.date_finish }}</td>
                        </tr>
                        <tr>
                          <td>Waktu Mengerjakan</td>
                          <td>:</td>
                          <td>{{ item.time }}</td>
                        </tr>
                        <tr>
                          <td>Jumlah Soal</td>
                          <td>:</td>
                          <td>{{ item.question_count }}</td>
                        </tr>
                      </tbody>
                    </template>
                  </v-simple-table>
                </v-card-text>
                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn
                    color="red darken-1"
                    text
                    @click="dialog[item.id] = false"
                  >
                    Cancel
                  </v-btn>
                  <v-btn
                    color="green darken-1"
                    text
                    @click="postTryOut(item)"
                    :loading="btnLoading"
                  >
                    Kerjakan
                  </v-btn>
                </v-card-actions>
              </v-card>
            </v-dialog>
          </v-card-actions>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>
<script>
export default {
  data() {
    return {
      tryouts: [],
      dialog: {},
      btnLoading: false,
    };
  },
  mounted() {
    axios
      .get(`${this.$baseUrl}/api/s/tryout`)
      .then((result) => {
        this.tryouts = result.data.data;
      })
      .catch((err) => {});
  },
  methods: {
    postTryOut(item) {
      this.btnLoading = true;
      axios
        .post(`${this.$baseUrl}/api/s/tryout`, item)
        .then((result) => {
          this.btnLoading = false;
          this.$router.push({
            name: "dashboard.tryout.show",
            params: { id: item.id },
          });
          console.log("result", result);
        })
        .catch((err) => {});
    },
  },
};
</script>