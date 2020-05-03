<template>
  <div class="tank-history">
      <span>Tank history</span>
      <TankHistoryTable  v-bind:tankHistory="tankHistory"/>
      <AddTankHistory v-bind:actualCar="actualCar" v-if="showModal" @close="showModal = false">
        <h3 slot="header">Add tank record</h3>
      </AddTankHistory>
      <button id="show-modal" @click="showModal = true">Add tank</button>
  </div>
</template>

<script>
import TankHistoryTable from './TankHistoryTable';
import AddTankHistory from './AddTankHistory';

export default {
    name: 'CarTankHistory',
    components: {
      TankHistoryTable, AddTankHistory
    },
    props: {
      actualCar: Number
    },
    data: function() {
        return {
            tankHistory: [],
            showModal: false
        }
    },
    created: function() {
        var json = {
          idCar: this.actualCar
        };
        
        var requestOptions = {
          method: 'GET',
          body: JSON.stringify(json),
          redirect: 'follow',
          credentials: 'include'
        };

        fetch(`http://marcin.innome.pl:8000/tank_history/`, requestOptions)
        .then(response => response.json())
        .then((result) => {
          console.log(result);
          this.tankHistory = result;
        })
        .catch(error => console.log('error', error));
    }
}
</script>

<style>
  .tank-history {
    color: white;

  }

  span {
    color: white;
  }
</style>