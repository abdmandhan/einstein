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
              <th class="text-left">Time</th>
              <th class="text-left">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(item, i) in learning.course.course_task" :key="i">
              <td>{{ item.name }}</td>
              <td>{{ item.difficulty.name }}</td>
              <td>{{ item.time }}</td>
              <td>
                <v-btn color="green" icon><v-icon>mdi-play-box</v-icon></v-btn>
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