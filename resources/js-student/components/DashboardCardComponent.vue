<template>
  <v-container>
    <v-row>
      <v-col>
        <v-card>
          <v-card-title>Announcement</v-card-title>
          <v-card-text>
            <div v-for="(item, i) in announcements" :key="i">
              {{ item.title }} {{ item.created_at }}
              <v-btn text x-small color="primary" @click="openDialog(item)"
                >detail</v-btn
              >
            </div>
            <v-dialog v-model="dialog" width="500">
              <v-card>
                <v-card-title class="headline grey lighten-2 mt-5">
                  {{ announcement.title }}
                </v-card-title>

                <v-card-text class="mt-5">
                  {{ announcement.content }}
                </v-card-text>

                <v-divider></v-divider>

                <v-card-actions>
                  {{ announcement.created_at }}
                  <v-spacer></v-spacer>
                  <v-btn color="primary" text @click="dialog = false">
                    Close
                  </v-btn>
                </v-card-actions>
              </v-card>
            </v-dialog>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
    <v-row>
      <v-col cols="4" v-for="n in 3" :key="n">
        <v-card class="mx-4">
          <v-card-title> Test </v-card-title>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {
  data() {
    return {
      dialog: false,
      announcements: [],
      announcement: {},
    };
  },
  mounted() {
    axios
      .get(`${this.$baseUrl}/api/announcement`)
      .then((result) => {
        this.announcements = result.data.data;
      })
      .catch((err) => {});
  },
  methods: {
    openDialog(announcement) {
      this.announcement = announcement;
      this.dialog = true;
    },
  },
};
</script>