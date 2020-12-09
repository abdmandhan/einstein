<template>
  <div>
    <v-container>
      <v-row>
        <v-col cols="2">
          <v-sheet rounded="lg">
            <v-list color="transparent">
              <v-list-item v-for="(link, i) in links" :key="i" link>
                <v-list-item-content>
                  <v-list-item-title>
                    <v-btn text :to="{ name: link.name }">
                      {{ link.title }}
                    </v-btn>
                  </v-list-item-title>
                </v-list-item-content>
              </v-list-item>
            </v-list>
          </v-sheet>
        </v-col>

        <v-col>
          <v-sheet rounded="lg">
            <router-view name="sub"></router-view>
          </v-sheet>
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>

<script>
export default {
  data: () => ({
    links: [
      {
        title: "Learning",
        name: "dashboard.learning",
      },
      {
        title: "Course",
        name: "dashboard.course",
      },
      {
        title: "Teacher",
        name: "dashboard.teacher",
      },
      {
        title: "Try Out",
        name: "dashboard.tryout",
      },
      {
        title: "Transaction",
        name: "dashboard.transaction",
      },
      {
        title: "Discussion",
        name: "dashboard.discussion",
      },
    ],
  }),
  methods: {},
  mounted() {
    console.log(this.$userId);
  },
};
</script>