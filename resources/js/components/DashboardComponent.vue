<template>
  <div>
    <dashboard-card-component :cards="cards" />
  </div>
</template>

<script>
export default {
  data: () => ({
    loading: false,
    cards: [],
  }),
  mounted() {
    axios
      .get(`${this.$baseUrl}/api/dashboard`)
      .then((result) => {
        this.cards = result.data.data.cards;
        console.log("RESULT", result);
      })
      .catch((err) => {});
    console.log(this.$userId);
  },
};
</script>