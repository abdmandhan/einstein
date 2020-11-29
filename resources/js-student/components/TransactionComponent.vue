<template>
  <div>
    <transaction-table-component :transactions="transactions" />
  </div>
</template>

<script>
export default {
  data() {
    return {
      transactions: [],
    };
  },
  mounted() {
    axios.get(`${this.$baseUrl}/api/student`).then((result) => {
      this.transactions = result.data.data.transactions;
      this.loading = false;
    });
  },
};
</script>