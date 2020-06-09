<template>
  <div class="repair-history">
      <span>Repair history</span>
      <div class="action-table">
        <RepairHistoryTable v-bind:repairHistory="repairHistory"/>
      </div>
      <AddRepairHistory v-bind:actualCar="actualCar" v-if="showModal" @close="showModal = false">
        <h3 slot="header">Add repair record</h3>
      </AddRepairHistory>
      <button class="btn btn-success w-50 m-auto" id="show-modal" @click="showModal = true">Add repair</button>
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

        fetch(`${process.env.VUE_APP_API_URL}/repair_history/`, requestOptions)
        .then(response => response.json())
        .then((result) => {
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
          this.repairHistory = result;
        })
        .catch(error => console.log('error', error));
      }
    }
}
</script>

<style scoped>
  .repair-history {
    color: white;
    height: 100%;
    overflow: auto;

  }
  .action-table {
    width: 100%;
    height: 80%;
    overflow: auto;
  }
  span {
    color: white;
  }
</style>