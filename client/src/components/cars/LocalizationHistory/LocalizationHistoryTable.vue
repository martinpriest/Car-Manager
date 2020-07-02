<template>
  <div>
    <table
      style="padding" class="table table-bordered table-hover table-dark w-75 overflow-auto m-auto"
      v-if="localizationHistory.length"
    >
      <thead>
        <tr>
          <th>Description</th>
          <th>Distance</th>
          <th>Date</th>
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
    localizationHistory: Array
  }
};
</script>

<style>
</style>
