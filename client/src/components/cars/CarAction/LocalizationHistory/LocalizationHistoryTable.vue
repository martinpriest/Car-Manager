<template>
  <div>
    <table
      class="table table-hover table-dark w-75 overflow-auto"
      v-if="localizationHistory.length"
    >
      <thead>
        <tr>
          <th>Skąd</th>
          <th>Do</th>
          <th>Dystans</th>
          <th>Kiedy</th>
        </tr>
      </thead>

      <tbody>
        <tr
          v-for="record in localizationHistory"
          :key="record.id"
          :data-id-localization="record.id"
        >
          <td>{{ record.startLocalizationName }}</td>
          <td>{{ record.endLocalizationName }}</td>
          <td>{{ record.distance }}</td>
          <td>{{ record.date.date }}</td>
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
