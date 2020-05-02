<template>
  <div>
      <table>
          <tr>
              <th>Gdzie</th>
              <th>Kiedy</th>
              <th>Ile</th>
              <th>Czego</th>
          </tr>
          <tr v-for="tank in tankHistory" :key ="tank.id">
              <td>{{ tank.petrolStation }}</td>
              <td>{{ tank.date.date }}</td>
              <td>{{ tank.amount }} l</td>
              <td>{{ tank.idPetrolType }}</td>
          </tr>
      </table>
  </div>
</template>

<script>
export default {
    name: 'TankHistoryTable',
    props: {
        tankHistory: Array
    }
}
</script>

<style>

</style>