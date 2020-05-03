<template>
  <div class="repair-history">
      <span>Repair history</span>
      <RepairHistoryTable v-bind:repairHistory="repairHistory"/>
      <AddRepairHistory v-bind:actualCar="actualCar" v-if="showModal" @close="showModal = false">
        <h3 slot="header">Add repair record</h3>
      </AddRepairHistory>
      <button id="show-modal" @click="showModal = true">Add repair</button>
  </div>
</template>

<script>
import RepairHistoryTable from './RepairHistoryTable';
import AddRepairHistory from './AddRepairHistory';

export default {
    name: 'CarRepairHistory',
    components: {
      RepairHistoryTable, AddRepairHistory
    },
    props: {
      actualCar: Number
    },
    data: function() {
        return {
            repairHistory: [],
            showModal: false
        }
    },
    created: function() {
        var json = {
          idCar: this.actualCar
        };

        var requestOptions = {
          method: 'POST',
          body: JSON.stringify(json),
          redirect: 'follow',
          credentials: 'include'
        };

        fetch(`http://marcin.innome.pl:8000/repair_history/`, requestOptions)
        .then(response => response.json())
        .then((result) => {
          console.log(result);
          this.repairHistory = result;
        })
        .catch(error => console.log('error', error));
    },
    watch: {
      actualCar: function() {
        var json = {
          idCar: this.actualCar
        };

        var requestOptions = {
          method: 'POST',
          body: JSON.stringify(json),
          redirect: 'follow',
          credentials: 'include'
        };

        fetch(`http://marcin.innome.pl:8000/repair_history/`, requestOptions)
        .then(response => response.json())
        .then((result) => {
          console.log(`Repair history: ${result}`);
          this.repairHistory = result;
        })
        .catch(error => console.log('error', error));
      }
    }
}
</script>

<style>
  .repair-history {
    color: white;

  }

  span {
    color: white;
  }
</style>