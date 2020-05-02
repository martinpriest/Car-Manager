<template>
  <div class="tank-history">
      <span>Tank history</span>
      <TankHistoryTable  v-bind:tankHistory="tankHistory"/>
      <!-- <ol>
        <li v-for="tank in tankHistory" :key ="tank.id">{{ tank.petrolStation }}</li>
      </ol> -->
      <button>Add tank</button>
  </div>
</template>

<script>
import TankHistoryTable from './TankHistoryTable';

export default {
    name: 'CarTankHistory',
    components: {
      TankHistoryTable
    },
    data: function() {
        return {
            tankHistory: []
        }
    },
    created: function() {
        var requestOptions = {
          method: 'GET',
          redirect: 'follow',
          credentials: 'include'
        };

        fetch("http://marcin.innome.pl:8000/tank_history", requestOptions)
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