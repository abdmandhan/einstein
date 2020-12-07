<template>
  <v-card class="mx-auto" tile>
    <v-row align="end">
      <v-col align-self="start" class="pa-0" cols="12">
        <v-avatar class="ml-5 mt-2" color="grey" size="160" tile>
          <v-img :src="photo"></v-img>
        </v-avatar>
        <v-list-item>
          <v-list-item-content>
            <v-list-item-title class="title">
              {{ teacher.name }}
            </v-list-item-title>
            <v-list-item-subtitle>
              <div>
                <v-icon>mdi-cellphone</v-icon>
                {{ teacher.phone }}
              </div>
              <div>
                <v-icon>mdi-email</v-icon>
                {{ teacher.email }}
              </div>
              <div>
                <v-icon>mdi-shield-home-outline</v-icon>
                {{ teacher.address }}
              </div>
              <span v-if="teacher.user_teacher">
                <div>
                  <v-icon>mdi-account-network</v-icon>
                  {{ teacher.user_teacher.position.name }}
                </div>
                <div>
                  <v-icon>mdi-chart-pie</v-icon>
                  {{ teacher.user_teacher.golongan.name }}
                </div>
                <div>
                  <v-icon>mdi-book-open-variant</v-icon>
                  {{ teacher.user_teacher.education.name }}
                </div>
              </span>
            </v-list-item-subtitle>
          </v-list-item-content>
        </v-list-item>
      </v-col>
    </v-row>
  </v-card>
</template>

<script>
export default {
  props: {
    teacher: {
      type: Object,
    },
  },
  computed: {
    photo() {
      return `${this.$baseUrl}/${this.teacher.photo}`;
    },
    background() {
      return `${this.$baseUrl}/storage/other/classroom.jpg`;
    },
  },
};
</script>