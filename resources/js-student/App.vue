<template>
  <v-app id="inspire">
    <v-app-bar app color="white" flat>
      <v-container class="py-0 fill-height">
        <v-avatar class="mr-10" color="grey darken-1" size="32">
          <v-img src="https://randomuser.me/api/portraits/men/85.jpg"></v-img>
        </v-avatar>

        <v-btn
          v-for="link in links"
          :key="link.name"
          text
          :to="{ name: link.name }"
        >
          {{ link.title }}
        </v-btn>
        <v-spacer></v-spacer>
        <v-btn text :to="{ name: 'profile' }">Profile</v-btn>
        <v-btn text @click="logout">Logout</v-btn>
      </v-container>
    </v-app-bar>

    <v-main class="grey lighten-3">
      <router-view></router-view>
    </v-main>
  </v-app>
</template>

<script>
export default {
  data: () => ({
    links: [
      {
        title: "Dashboard",
        name: "dashboard",
      },
      {
        title: "My Course",
        name: "my-course",
      },
      {
        title: "Try Out",
        name: "tryout",
      },
    ],
  }),
  methods: {
    logout() {
      axios.post(`${this.$baseUrl}/logout`).then((result) => {
        window.location.href = this.$baseUrl;
      });
    },
  },
};
</script>