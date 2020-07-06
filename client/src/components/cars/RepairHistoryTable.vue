<template>
  <div>
    <table class="table table-hover table-bordered table-dark w-75 overflow-auto m-auto" v-if="repairHistory.length">
      <thead>
        <tr>
          <th>Date</th>
          <th>Description</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="repair in repairHistory" :key="repair.id">
          <td>{{ repair.date }}</td>
          <td>{{ repair.description }}</td>
          <td><b-button variant="danger" @click="deleteRepair(repair)">Delete</b-button></td>
        </tr>
      </tbody>
    </table>
    <p v-else>No repair history</p>
  </div>
</template>

<script>
export default {
  name: "RepairHistoryTable",
  props: {
    repairHistory: [Object, Array]
  },
  methods: {
    deleteRepair(repair) {
      var requestOptions = {
        method: "DELETE",
        redirect: "follow",
        credentials: "include"
      };

      fetch(`${process.env.VUE_APP_API_URL}/repair_history/${repair.id}`, requestOptions)
        .then(response => response.json())
        .then(result => {
          console.log(result);
          var index = this.repairHistory.map(x => {
            return x.id;
          }).indexOf(repair.id);

          this.repairHistory.splice(index, 1);
        })
        .catch(error => console.log("error", error));
    }
  }
};
</script>

<style>
</style>