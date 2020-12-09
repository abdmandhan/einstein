<template>
  <div>
    <transaction-table-component :transactions="transactions" :loading="loading"/>
  </div>
</template>

<script>
export default {
  data() {
    return {
      transactions: [],
      loading:true,
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