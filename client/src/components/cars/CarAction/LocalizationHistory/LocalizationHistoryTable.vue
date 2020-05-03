<template>
  <div>
      <table>
          <tr>
              <th>Skąd</th>
              <th>Do</th>
              <th>Dystans</th>
              <th>Kiedy</th>
          </tr>
          <tr v-for="record in localizationHistory" :key="record.id" :data-id-localization="record.id">
              <td> {{ record.startLocalizationName }} </td>
              <td> {{ record.endLocalizationName }} </td>
              <td> {{ record.distance }} </td>
              <td> {{ record.date.date }} </td>
          </tr>
      </table>
  </div>
</template>

<script>
export default {
    name: 'LocalizationHistoryTable',
    props: {
        localizationHistory: Array
    }
}
</script>

<style>

</style>
