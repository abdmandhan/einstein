<template>
  <v-container>
    <v-card v-if="learning.course">
      <v-card-title>{{ learning.course.name }}</v-card-title>
      <v-card-text>
        Bahan Materi
        <br />
        <v-simple-table>
          <template v-slot:default>
            <thead>
              <tr>
                <th class="text-left">Name</th>
                <th class="text-left">Desc</th>
                <th class="text-left">File</th>
                <th class="text-left">Video</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(item, i) in learning.course.course_content" :key="i">
                <td>{{ item.name }}</td>
                <td>{{ item.desc }}</td>
                <td>
                  <v-tooltip bottom>
                    <template v-slot:activator="{ on, attrs }">
                      <v-btn
                        icon
                        v-bind="attrs"
                        v-on="on"
                        :href="photo(item.file)"
                      >
                        <v-icon color="red">mdi-file-pdf</v-icon>
                      </v-btn>
                    </template>
                    <span>View</span>
                  </v-tooltip>
                </td>
                <td>
                  <v-dialog v-model="dialogPreview[item.id]">
                    <template v-slot:activator="{ on, attrs }">
                      <v-tooltip bottom>
                        <template v-slot:activator="{ on, attrs }">
                          <v-btn
                            icon
                            v-bind="attrs"
                            v-on="on"
                            @click.stop="$set(dialogPreview, item.id, true)"
                          >
                            <v-icon color="red">mdi-youtube</v-icon>
                          </v-btn>
                        </template>
                        <span>Open</span>
                      </v-tooltip>
                    </template>

                    <v-card>
                      <v-card-title class="headline grey lighten-2">
                        Youtube
                      </v-card-title>

                      <v-card-text class="text-center mt-5">
                        <iframe
                          width="600"
                          height="400"
                          :src="item.url_youtube"
                          frameborder="0"
                          allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                          allowfullscreen
                        ></iframe>
                      </v-card-text>

                      <v-divider></v-divider>

                      <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                          color="primary"
                          text
                          @click.stop="$set(dialogPreview, item.id, false)"
                        >
                          Close
                        </v-btn>
                      </v-card-actions>
                    </v-card>
                  </v-dialog>
                </td>
              </tr>
            </tbody>
          </template>
        </v-simple-table>
      </v-card-text>
    </v-card>
  </v-container>
</template>

<script>
export default {
  data() {
    return {
      learning: {},
      loading: true,
      dialogPreview: {},
    };
  },
  mounted() {
    axios
      .get(`${this.$baseUrl}/api/s/learning/${this.$route.params.id}`)
      .then((result) => {
        if (result.data.status) {
          this.loading = false;
          this.learning = result.data.data;
        } else {
          this.$router.push({ name: "dashboard.learning" });
        }
        console.log("result", result, this.learning);
      })
      .catch((err) => {});
  },
  methods: {
    photo(name) {
      return `${this.$baseUrl}/${name}`;
    },
  },
  watch: {
    dialogPreview: (val) => {
      console.log("dp", val);
    },
  },
};
</script>