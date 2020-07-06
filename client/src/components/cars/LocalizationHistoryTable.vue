<template>
  <div>
    <table
      class="table table-bordered table-hover table-dark w-75 overflow-auto m-auto"
      v-if="localizationHistory.length"
    >
      <thead>
        <tr>
          <th>Description</th>
          <th>Distance</th>
          <th>Date</th>
          <th>Action</th>
        </tr>
      </thead>

      <tbody>
        <tr
          v-for="record in localizationHistory"
          :key="record.id"
          :data-id-localization="record.id"
        >
          <td>{{ record.description }}</td>
          <td>{{ record.distance }} km</td>
          <td>{{ record.date }}</td>
          <td><b-button variant="danger" @click="deleteLocalization(record)">Delete</b-button></td>
        </tr>
      </tbody>
    </table>
    <p v-else>No records</p>
  </div>
</template>

<script>
export default {
  name: "LocalizationHistoryTable",
  props: {
    localizationHistory: [Object, Array]
  },
  methods: {
    deleteLocalization(localization) {
      var requestOptions = {
        method: "DELETE",
        redirect: "follow",
        credentials: "include"
      };

      fetch(`${process.env.VUE_APP_API_URL}/localization_history/${localization.id}`, requestOptions)
        .then(response => response.json())
        .then(result => {
          console.log(result);
          var index = this.localizationHistory.map(x => {
            return x.id;
          }).indexOf(localization.id);

          this.localizationHistory.splice(index, 1);
        })
        .catch(error => console.log("error", error));
    }
  }
};
</script>

<style>
</style>
