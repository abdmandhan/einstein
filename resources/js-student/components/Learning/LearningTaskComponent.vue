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
              <th class="text-left">Task Time</th>
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
              <td>{{ item.course_task.time }}</td>
              <td>{{ item.score }}</td>
              <td>{{ item.start_finish }}</td>
              <td>{{ item.finish_date }}</td>
              <td>
                <v-tooltip bottom>
                  <template v-slot:activator="{ on, attrs }">
                    <v-btn color="green" icon v-bind="attrs" v-on="on"
                      ><v-icon>mdi-play-box</v-icon></v-btn
                    >
                  </template>
                  <span>Kerjakan</span>
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
      dialogPreview: {},
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
  },
};
</script>