<template>
  <v-card>
    <v-card-text>
      Tugas Belajar
      <br />
      <v-simple-table>
        <template v-slot:default>
          <thead>
            <tr>
              <th class="text-left">Name</th>
              <th class="text-left">Difficulty</th>
              <th class="text-left">Score</th>
              <th class="text-left">Start Date</th>
              <th class="text-left">Finish Date</th>
              <th class="text-left">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="(item, i) in learning.course.course_task_student"
              :key="i"
            >
              <td>{{ item.course_task.name }}</td>
              <td>{{ item.course_task.difficulty.name }}</td>
              <td>{{ item.score }}</td>
              <td>{{ item.start_date }}</td>
              <td>{{ item.finish_date }}</td>
              <td>
                <v-tooltip bottom v-if="!item.finish_date">
                  <template v-slot:activator="{ on, attrs }">
                    <v-btn
                      color="green"
                      icon
                      v-bind="attrs"
                      v-on="on"
                      @click="openDialog(item)"
                      ><v-icon>mdi-play-box</v-icon></v-btn
                    >
                    <v-dialog v-model="dialog" persistent max-width="290">
                      <v-card>
                        <v-card-title class="headline">
                          {{ dialogTitle }}
                        </v-card-title>
                        <v-card-text>
                          <!-- Waktu Mengerjakan : {{ dialogTime }} -->
                        </v-card-text>
                        <v-card-actions>
                          <v-spacer></v-spacer>
                          <v-btn
                            color="red darken-1"
                            text
                            @click="dialog = false"
                          >
                            Cancel
                          </v-btn>
                          <v-btn
                            color="green darken-1"
                            text
                            @click="startLearning(item)"
                            :loading="btnLoading"
                          >
                            Mulai Kerjakan
                          </v-btn>
                        </v-card-actions>
                      </v-card>
                    </v-dialog>
                  </template>
                  <span>Kerjakan</span>
                </v-tooltip>
                <v-tooltip bottom v-else>
                  <template v-slot:activator="{ on, attrs }">
                    <v-btn
                      color="green"
                      icon
                      v-bind="attrs"
                      v-on="on"
                      @click="openDialogReview(item)"
                      ><v-icon>mdi-book-check-outline</v-icon></v-btn
                    >
                    <v-dialog v-model="dialogReview" persistent>
                      <v-card>
                        <v-card-title class="headline"> Review </v-card-title>
                        <v-card-text>
                          <v-simple-table>
                            <template v-slot:default>
                              <thead>
                                <tr>
                                  <th class="text-left">No</th>
                                  <th class="text-left">Question</th>
                                  <th class="text-left">Your Answer</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr
                                  v-for="(a, b) in item.course_task
                                    .course_task_student_answer"
                                  :key="b"
                                >
                                  <td>{{ b + 1 }}</td>
                                  <td>{{ a.question.question }}</td>
                                  <td v-if="a.question.question_type_id == 1">
                                    {{ a.answer.answer }}
                                  </td>
                                  <td v-else>{{ a.answer_essay }}</td>
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
                            @click="dialogReview = false"
                          >
                            Cancel
                          </v-btn>
                        </v-card-actions>
                      </v-card>
                    </v-dialog>
                  </template>
                  <span>Review</span>
                </v-tooltip>
              </td>
            </tr>
          </tbody>
        </template>
      </v-simple-table>
    </v-card-text>
  </v-card>
</template>

<script>
export default {
  data() {
    return {
      dialog: false,
      dialogTitle: "",
      dialogTime: "",
      dialogReview: false,
      btnLoading: false,
    };
  },
  props: {
    learning: {
      default: {},
    },
    loading: {
      default: true,
    },
  },
  methods: {
    photo(name) {
      return `${this.$baseUrl}/${name}`;
    },
    openDialog(item) {
      this.dialogTitle = item.course_task.name;
      // this.dialogTime = item.course_task.time;
      this.dialog = true;
    },
    openDialogReview(item) {
      this.dialogReview = true;
    },
    startLearning(item) {
      axios
        .post(`${this.$baseUrl}/api/s/learning`, item)
        .then((result) => {
          console.log("item", item);
          this.btnLoading = false;
          this.$router.push({
            name: "dashboard.learning.task.show",
            params: { id: item.course_task_id },
          });
          console.log("result", result);
        })
        .catch((err) => {});
      this.btnLoading = true;
    },
  },
};
</script>