<template>
  <v-app id="inspire">
    <v-app-bar app color="white" flat>
      <v-container class="py-0 fill-height">
        <v-avatar class="mr-10" color="grey darken-1" size="32">
          <!-- <v-img src="https://randomuser.me/api/portraits/men/85.jpg"></v-img> -->
          <v-img :src="photo"></v-img>
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
    userPhoto: "storage/user/1.jpg",
    links: [
      {
        title: "Dashboard",
        name: "dashboard",
      },
      {
        title: "Course",
        name: "course",
      },
      {
        title: "Teacher",
        name: "teacher",
      },
      {
        title: "Try Out",
        name: "tryout",
      },
      {
        title: "Transaction",
        name: "transaction",
      },
    ],
  }),
  mounted() {
    axios.get(`${this.$baseUrl}/api/app`).then((result) => {
      this.userPhoto = result.data.auth.photo;
    });
  },
  computed: {
    photo() {
      return `${this.$baseUrl}/${this.userPhoto}`;
    },
  },
  methods: {
    logout() {
      axios.post(`${this.$baseUrl}/logout`).then((result) => {
        window.location.href = this.$baseUrl;
      });
    },
  },
};
</script>