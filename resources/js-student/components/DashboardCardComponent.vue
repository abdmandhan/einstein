<template>
  <v-container>
    <v-row>
      <v-col>
        <v-card>
          <v-card-title>Welcome {{ auth.name }}</v-card-title>
          <v-card-subtitle>Dashboard</v-card-subtitle>
          <v-card-text>
            <v-container>
              <v-row>
                <v-col>
                  <v-sheet tile height="54" class="d-flex">
                    <v-btn icon class="ma-2" @click="$refs.calendar.prev()">
                      <v-icon>mdi-chevron-left</v-icon>
                    </v-btn>
                    <v-spacer></v-spacer>
                    <span v-if="$refs.calendar" class="mt-4">
                      {{ $refs.calendar.title }}
                    </span>
                    <v-spacer></v-spacer>
                    <v-btn icon class="ma-2" @click="$refs.calendar.next()">
                      <v-icon>mdi-chevron-right</v-icon>
                    </v-btn>
                  </v-sheet>
                  <v-sheet height="600">
                    <v-calendar
                      ref="calendar"
                      v-model="value"
                      :weekdays="weekday"
                      :type="type"
                      :events="events"
                      :event-overlap-mode="mode"
                      :event-overlap-threshold="30"
                      event-color="green"
                    ></v-calendar>
                  </v-sheet>
                </v-col>
              </v-row>
              <v-row>
                <v-col>
                  <v-card>
                    <v-card-title>Announcement</v-card-title>
                    <v-card-text>
                      <div v-for="(item, i) in announcements" :key="i">
                        {{ item.title }} {{ item.created_at }}
                        <v-btn
                          text
                          x-small
                          color="primary"
                          @click="openDialog(item)"
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
                <v-col cols="6">
                  <v-card>
                    <v-card-title>Try Out</v-card-title>
                    <v-card-text>
                      <v-simple-table dense>
                        <template v-slot:default>
                          <tbody>
                            <tr>
                              <td>Semua</td>
                              <td>
                                <v-chip
                                  v-for="(a, b) in tryout.all"
                                  :key="b"
                                  small
                                >
                                  {{ a.name }}
                                </v-chip>
                              </td>
                            </tr>
                            <tr>
                              <td>Sedang Berlangsung / Menuggu Review</td>
                              <td>
                                <v-chip
                                  v-for="(a, b) in tryout.ongoing"
                                  :key="b"
                                  small
                                >
                                  {{ a.tryout.name }}
                                </v-chip>
                              </td>
                            </tr>
                            <tr>
                              <td>Selesai</td>
                              <td>
                                <v-chip
                                  v-for="(a, b) in tryout.finish"
                                  :key="b"
                                  small
                                >
                                  {{ a.tryout.name }}
                                </v-chip>
                              </td>
                            </tr>
                          </tbody>
                        </template>
                      </v-simple-table>
                    </v-card-text>
                  </v-card>
                </v-col>
                <v-col cols="6">
                  <v-card>
                    <v-card-title>Course</v-card-title>
                    <v-card-text>
                      <v-simple-table dense v-if="courses.length > 0">
                        <template v-slot:default>
                          <tbody>
                            <tr>
                              <td>
                                <v-chip
                                  v-for="(a, b) in courses"
                                  :key="b"
                                  small
                                >
                                  {{ a.course.name }}
                                </v-chip>
                              </td>
                            </tr>
                          </tbody>
                        </template>
                      </v-simple-table>
                      <v-alert v-else color="yellow"
                        >Anda belum memiliki course</v-alert
                      >
                    </v-card-text>
                  </v-card>
                </v-col>
              </v-row>
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
      dialog: false,
      announcements: [],
      announcement: {},
      auth: {},
      tryout: {},
      courses: [],
      type: "month",
      mode: "stack",
      weekday: [0, 1, 2, 3, 4, 5, 6],
      value: "",
      events: [],
      colors: ["green"],
      names: ["Hadir"],
    };
  },
  mounted() {
    axios
      .get(`${this.$baseUrl}/api/announcement`)
      .then((result) => {
        this.announcements = result.data.data.announcements;
        this.auth = result.data.data.auth;
        this.tryout = result.data.data.tryout;
        this.courses = result.data.data.courses;
        this.convertDate(result.data.data.absensi);
      })
      .catch((err) => {});
  },
  methods: {
    openDialog(announcement) {
      this.announcement = announcement;
      this.dialog = true;
    },
    convertDate(events) {
      const ev = [];

      events.forEach((element, key) => {
        var start = new Date(0);
        start.setUTCSeconds(element.start);

        var end = new Date(0);
        end.setUTCSeconds(element.end);

        ev.push({
          name: element.name,
          start: start,
          end: end,
          color: element.color,
          timed: element.timed,
        });
      });

      this.events = ev;
      console.log("events", this.events);
    },
  },
};
</script>