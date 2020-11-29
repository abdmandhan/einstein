<template>
  <div>
    <v-container>
      <v-row>
        <v-col v-for="(item, index) in count" :key="index" cols="4" md="4">
          <v-skeleton-loader
            v-bind="attrs"
            type="card-avatar, article, actions"
          ></v-skeleton-loader>
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>

<script>
export default {
  data() {
    return {
      attrs: {
        class: "mb-6",
        boilerplate: true,
        elevation: 2,
      },
    };
  },
  props: {
    count: {
      type: Number,
      default: 3,
    },
  },
};
</script>