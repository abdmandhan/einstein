<template>
  <v-container>
    <v-row>
      <v-col cols="12" class="text-center mb-2">
        <h2>{{ task.name }}</h2>
      </v-col>
    </v-row>
    <v-row>
      <v-card
        v-for="(item, i) in task.course_task_question"
        :key="i"
        class="mb-5"
      >
        <v-card-title>{{ i + 1 }}. {{ item.question }}</v-card-title>
        <v-card-text>
          <v-radio-group v-model="answer[item.id]">
            <v-radio
              v-for="(ans, j) in item.course_task_answer"
              :key="j"
              :label="ans.answer"
              :value="ans.id"
              color="success"
            ></v-radio>
          </v-radio-group>
        </v-card-text>
      </v-card>
    </v-row>
    <v-row>
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
                @click="postTask()"
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
      task: {},
      answer: {},
      page: 1,
      dialog: false,
      btnLoading: false,
      message: false,
    };
  },
  mounted() {
    axios
      .get(`${this.$baseUrl}/api/s/learning-task/${this.$route.params.id}`)
      .then((result) => {
        this.task = result.data.data;
        this.task.course_task_question.forEach((element) => {
          this.answer[element.id] = null;
        });
        console.log("element", this.answer);
        console.log("result", result, this.task);
      })
      .catch((err) => {});
  },
  methods: {
    openDialog() {
      this.dialog = true;
      this.message = false;
    },
    postTask() {
      //validasi answer harus dijawab semua
      this.message = false;
      for (const key in this.answer) {
        if (!this.answer[key]) {
          this.message = true;
          return;
        }
      }

      this.btnLoading = true;
      axios
        .post(`${this.$baseUrl}/api/s/learning-task`, {
          task: this.task,
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