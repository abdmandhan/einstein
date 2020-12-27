<template>
  <v-container>
    <v-row>
      <v-col>
        <v-card>
          <v-card-title
            >Edit Course Task {{ course_task.id }}
            <v-spacer />
            <v-btn @click="back()" color="primary">Back</v-btn>
          </v-card-title>
          <v-card-text>
            <v-container>
              <v-row>
                <v-col cols="6">
                  <v-text-field
                    class="mt-5"
                    dense
                    v-model="course_task.name"
                    label="Name"
                    :error-messages="errors.name"
                  ></v-text-field>
                </v-col>

                <v-col cols="6">
                  <v-select
                    item-text="name"
                    item-value="id"
                    error-count="2"
                    v-model="course_task.difficulty_id"
                    :items="options.difficulties"
                    label="Difficulty"
                    :error-messages="errors.difficulty_id"
                  ></v-select>
                </v-col>
              </v-row>

              <v-row>
                <v-col cols="12">
                  <v-data-table
                    :headers="headers"
                    :items="items"
                    sort-by="calories"
                    class="elevation-1"
                  >
                    <template v-slot:top>
                      <v-toolbar flat>
                        <v-toolbar-title>Task Question</v-toolbar-title>
                        <v-spacer></v-spacer>
                        <v-dialog v-model="dialog">
                          <template v-slot:activator="{ on, attrs }">
                            <v-btn
                              color="primary"
                              dark
                              class="mb-2"
                              v-bind="attrs"
                              v-on="on"
                            >
                              New Item
                            </v-btn>
                          </template>
                          <v-card>
                            <v-card-title>
                              <span class="headline">{{ formTitle }}</span>
                            </v-card-title>

                            <v-card-text>
                              <v-container>
                                <v-row>
                                  <v-col cols="12">
                                    <v-textarea
                                      class="mt-5"
                                      dense
                                      v-model="question.name"
                                      label="Question"
                                      :error-messages="errors.name"
                                    ></v-textarea>
                                  </v-col>

                                  <v-col cols="6">
                                    <v-select
                                      item-text="name"
                                      item-value="id"
                                      v-model="question.question_type_id"
                                      :items="options.question_types"
                                      label="Question Type"
                                      :error-messages="errors.question_type_id"
                                    ></v-select>
                                  </v-col>

                                  <!-- PG -->
                                  <v-col
                                    cols="12"
                                    v-if="question.question_type_id == 1"
                                  >
                                    <v-row v-for="a in 4" :key="a">
                                      <v-col cols="8">
                                        Jawaban
                                        <v-textarea
                                          dense
                                          v-model="answer[a]"
                                          :label="'Answer ' + a"
                                          rows="2"
                                        >
                                        </v-textarea>
                                      </v-col>

                                      <v-col cols="4">
                                        <v-radio-group v-model="radioGroup">
                                          <v-radio
                                            :label="`Radio ${a}`"
                                            :value="a"
                                          ></v-radio>
                                        </v-radio-group>
                                      </v-col>
                                    </v-row>
                                  </v-col>
                                </v-row>
                              </v-container>
                            </v-card-text>

                            <v-card-actions>
                              <v-spacer></v-spacer>
                              <v-btn color="blue darken-1" text @click="close">
                                Cancel
                              </v-btn>
                              <v-btn color="blue darken-1" text @click="save">
                                Save
                              </v-btn>
                            </v-card-actions>
                          </v-card>
                        </v-dialog>
                        <v-dialog v-model="dialogDelete" max-width="500px">
                          <v-card>
                            <v-card-title class="headline"
                              >Are you sure you want to delete this
                              item?</v-card-title
                            >
                            <v-card-actions>
                              <v-spacer></v-spacer>
                              <v-btn
                                color="blue darken-1"
                                text
                                @click="closeDelete"
                                >Cancel</v-btn
                              >
                              <v-btn
                                color="blue darken-1"
                                text
                                @click="deleteItemConfirm"
                                >OK</v-btn
                              >
                              <v-spacer></v-spacer>
                            </v-card-actions>
                          </v-card>
                        </v-dialog>
                      </v-toolbar>
                    </template>
                    <template v-slot:item.actions="{ item }">
                      <v-icon small class="mr-2" @click="editItem(item)">
                        mdi-pencil
                      </v-icon>
                      <v-icon small @click="deleteItem(item)">
                        mdi-delete
                      </v-icon>
                    </template>
                  </v-data-table>
                </v-col>
              </v-row>

              <v-btn block @click="store()" color="green">Save</v-btn>
            </v-container>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {
  data() {
    return {
      radioGroup: 1,
      course_task: {},
      question: {},
      answer: [],
      options: [],
      errors: [],
      dialog: false,
      dialogDelete: false,
      headers: [
        { text: "ID", value: "id" },
        { text: "Question Type", value: "question_type.name" },
        { text: "Question", value: "question" },
        { text: "Actions", value: "actions" },
      ],
      items: [],
      editedIndex: -1,
    };
  },
  mounted() {
    this.init();
  },
  computed: {
    formTitle() {
      return this.editedIndex === -1 ? "New Item" : "Edit Item";
    },
  },

  watch: {
    dialog(val) {
      val || this.close();
    },
    dialogDelete(val) {
      val || this.closeDelete();
    },
  },

  methods: {
    init() {
      axios
        .get(`${this.$baseUrl}/api/course-task/${this.$route.params.id}/edit`)
        .then((result) => {
          this.course_task = result.data.data.data;
          this.items = this.course_task.course_task_question;
          console.log("result", result);
        })
        .catch((err) => {});

      axios.get(`${this.$baseUrl}/api/options`).then((response) => {
        this.options = response.data;
      });
    },
    store() {
      axios
        .post(`${this.$baseUrl}/api/course-task`, this.course_task)
        .then((result) => {
          console.log("result", result);
        })
        .catch((err) => {});
    },
    back() {
      this.$router.back();
    },

    editItem(item) {
      this.editedIndex = this.items.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialog = true;
    },

    deleteItem(item) {
      this.editedIndex = this.items.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialogDelete = true;
    },

    deleteItemConfirm() {
      this.items.splice(this.editedIndex, 1);
      this.closeDelete();
    },

    close() {
      this.dialog = false;
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      });
    },

    closeDelete() {
      this.dialogDelete = false;
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      });
    },

    save() {
      if (this.editedIndex > -1) {
        Object.assign(this.items[this.editedIndex], this.editedItem);
      } else {
        this.items.push(this.editedItem);
      }
      this.close();
    },
  },
};
</script>