<template>
  <div>
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
            :value="j"
            color="success"
          ></v-radio>
        </v-radio-group>
      </v-card-text>
    </v-card>
  </div>
</template>

<script>
export default {
  props: {
    task: {
      default: {},
    },
  },
  data() {
    return {
      answer: {},
    };
  },
};
</script>