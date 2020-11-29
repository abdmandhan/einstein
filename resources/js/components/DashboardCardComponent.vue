<template>
  <div>
    <v-container>
      <v-row dense>
        <v-col v-for="(card, i) in cards" :key="i" cols="4">
          <v-card :color="card.color" dark>
            <div class="d-flex flex-no-wrap justify-space-between">
              <div>
                <v-card-title
                  class="headline"
                  v-text="card.title"
                ></v-card-title>

                <v-card-text> Jumlah : {{ card.count }} </v-card-text>
              </div>

              <v-avatar class="ma-3" size="125" tile>
                <v-icon x-large> {{ card.icon }} </v-icon>
              </v-avatar>
            </div>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>

<script>
export default {
  props: {
    cards: {
      type: Array,
    },
  },
};
</script>