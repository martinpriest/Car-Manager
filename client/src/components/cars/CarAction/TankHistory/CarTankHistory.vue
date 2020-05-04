<template>
  <div class="tank-history">
      <span>Tank history</span>
      <div class="action-table">
      <TankHistoryTable v-bind:tankHistory="tankHistory"/>
      </div>
      <AddTankHistory v-bind:actualCar="actualCar" v-if="showModal" @close="showModal = false">
        <h3 slot="header">Add tank record</h3>
      </AddTankHistory>
      <button class="btn btn-success w-50 m-auto" id="show-modal" @click="showModal = true">Add tank</button>
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
            tankHistory: Array || Object,
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

        fetch(`http://marcin.innome.pl:8000/tank_history/`, requestOptions)
        .then(response => response.json())
        .then((result) => {
          this.tankHistory = result;
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

        fetch(`http://marcin.innome.pl:8000/tank_history/`, requestOptions)
        .then(response => response.json())
        .then((result) => {
          this.tankHistory = result;
        })
        .catch(error => console.log('error', error));
      }
    }
}
</script>

<style>
  

  .tank-history {
    
    color: white;
    height: 100%;
    overflow: auto;
  }

  .action-table {
    height: 80%;
    overflow: auto;
  }
  span {
    color: white;
  }
</style>