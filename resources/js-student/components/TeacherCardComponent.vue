<template>
  <v-card class="mx-auto" max-width="434" tile>
    <v-img
      height="100%"
      src="https://cdn.vuetifyjs.com/images/cards/server-room.jpg"
    >
      <v-row align="end" class="fill-height">
        <v-col align-self="start" class="pa-0" cols="12">
          <v-avatar class="profile" color="grey" size="164" tile>
            <v-img
              src="https://cdn.vuetifyjs.com/images/profiles/marcus.jpg"
            ></v-img>
          </v-avatar>
        </v-col>
        <v-col class="py-0">
          <v-list-item color="rgba(0, 0, 0, .4)" dark>
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
              </v-list-item-subtitle>
            </v-list-item-content>
          </v-list-item>
        </v-col>
      </v-row>
    </v-img>
  </v-card>
</template>

<script>
export default {
  props: {
    teacher: {
      type: Object,
    },
  },
};
</script>