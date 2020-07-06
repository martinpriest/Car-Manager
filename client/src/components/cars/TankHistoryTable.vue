<template>
  <div>
    <table class="table table-hover table-bordered table-dark w-75 overflow-auto m-auto" v-if="tankHistory.length">
      <thead>
        <tr>
          <th>Station</th>
          <th>Date</th>
          <th>Amount</th>
          <th>Type</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="tank in tankHistory" :key="tank.id">
          <td>{{ tank.petrolStation }}</td>
          <td>{{ tank.date }}</td>
          <td>{{ tank.amount }} l</td>
          <td>{{ tank.petrolTypeName }}</td>
          <td><b-button variant="danger" @click="deleteRepair(tank)">Delete</b-button></td>
        </tr>
      </tbody>
    </table>
    <p v-else>No tank history</p>
  </div>
</template>

<script>
export default {
  name: "TankHistoryTable",
  props: {
    tankHistory: [Object, Array]
  },
  methods: {
    deleteRepair(tank) {
      var requestOptions = {
        method: "DELETE",
        redirect: "follow",
        credentials: "include"
      };

      fetch(`${process.env.VUE_APP_API_URL}/tank_history/${tank.id}`, requestOptions)
        .then(response => response.json())
        .then(result => {
          console.log(result);
          var index = this.tankHistory.map(x => {
            return x.id;
          }).indexOf(tank.id);

          this.tankHistory.splice(index, 1);
        })
        .catch(error => console.log("error", error));
    }
  }
};
</script>

<style>
</style>