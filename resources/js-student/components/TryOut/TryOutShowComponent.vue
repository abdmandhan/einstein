<template>
  <v-container>
    <v-row>
      <v-col cols="12" class="text-center mb-2" v-if="tryout">
        <h2>{{ tryout.name }}</h2>
        <vac :end-time="endtime" v-if="endtime" @finish="finish()">
          <span slot="process" slot-scope="{ timeObj }">{{
            `Waktu: ${timeObj.h}:${timeObj.m}:${timeObj.s}`
          }}</span>
          <span slot="finish">Done!</span>
        </vac>
      </v-col>
    </v-row>
    <v-row>
      <v-card
        v-for="(item, i) in tryout.try_out_question"
        :key="i"
        class="mb-5"
      >
        <v-card-title>{{ i + 1 }}. {{ item.question }}</v-card-title>
        <v-card-text>
          <v-radio-group
            v-model="answer[item.id]"
            v-if="item.question_type_id == 1"
          >
            <v-radio
              v-for="(ans, j) in item.try_out_answer"
              :key="j"
              :label="ans.answer"
              :value="ans.id"
              color="success"
            ></v-radio>
          </v-radio-group>
          <v-textarea v-else v-model="answer[item.id]"> </v-textarea>
        </v-card-text>
      </v-card>
    </v-row>
    <v-row v-if="!loading">
      <v-col cols="12" class="text-right">
        <v-dialog v-model="dialog" persistent max-width="500">
          <template v-slot:activator="{ on, attrs }">
            <v-btn
              color="primary"
              dark
              v-bind="attrs"
              v-on="on"
              @click="openDialog()"
            >
              Kumpulkan Tugas
            </v-btn>
          </template>
          <v-card>
            <v-card-title class="headline"> Review </v-card-title>
            <v-card-text>
              <div v-for="(a, b) in answer" :key="b">
                <span v-if="b != 0">
                  {{ b }}.
                  <span v-if="!a">
                    <v-chip color="red" small>Not Answered</v-chip>
                  </span>
                  <span v-else>
                    <v-chip small>{{ a }}</v-chip>
                  </span>
                </span>
              </div>
              <div class="mt-5" v-if="message">
                <v-alert border="bottom" color="red darken-1" dark>
                  Harap menjawab semua soal.
                </v-alert>
              </div>
            </v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="red darken-1" text @click="dialog = false">
                Cancel
              </v-btn>
              <v-btn
                color="green darken-1"
                text
                @click="postTryout()"
                :loading="btnLoading"
              >
                Kumpulkan
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {
  data() {
    return {
      tryout: {},
      answer: {},
      page: 1,
      dialog: false,
      btnLoading: false,
      message: false,
      loading: true,
      endtime: null,
      is_finish: false,
    };
  },
  mounted() {
    axios
      .get(`${this.$baseUrl}/api/s/tryout/${this.$route.params.id}`)
      .then((result) => {
        this.loading = false;
        this.tryout = result.data.data;
        this.endtime = new Date().getTime() + this.tryout.timestamp;
        this.tryout.try_out_question.forEach((element) => {
          this.answer[element.id] = null;
        });
      })
      .catch((err) => {});
  },
  methods: {
    finish() {
      this.is_finish = true;
      this.postTryout();
    },
    openDialog() {
      this.dialog = true;
      this.message = false;
    },
    postTryout() {
      if (!this.is_finish) {
        //validasi answer harus dijawab semua
        this.message = false;
        for (const key in this.answer) {
          if (!this.answer[key]) {
            this.message = true;
            return;
          }
        }
      }

      this.btnLoading = true;
      axios
        .put(`${this.$baseUrl}/api/s/tryout/${this.$route.params.id}`, {
          tryout: this.tryout,
          answer: this.answer,
        })
        .then((result) => {
          this.btnLoading = false;
          console.log("resultss", result);
          this.$router.back();
        })
        .catch((err) => {});
    },
  },
};
</script>