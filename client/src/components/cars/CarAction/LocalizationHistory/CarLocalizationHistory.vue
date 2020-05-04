<template>
  <div class="localization-history">
      <span>Localization History</span>
      <div class="action-table">
      <LocalizationHistoryTable v-bind:localizationHistory="localizationHistory"/>
      </div>
      <AddLocalizationHistory v-bind:actualCar="actualCar" v-if="showModal" @close="showModal = false"/>
      <button class="btn btn-success w-50 m-auto" id="show-localization-modal" @click="showModal = true">Add Localization</button>
  </div>
</template>

<script>
import LocalizationHistoryTable from './LocalizationHistoryTable'
import AddLocalizationHistory from './AddLocalizationHistory'
export default {
    name: 'CarLocalizationHistory',
    components: {
        LocalizationHistoryTable, AddLocalizationHistory
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

        fetch(`http://marcin.innome.pl:8000/localization_history/`, requestOptions)
        .then(response => response.json())
        .then((result) => {
          this.localizationHistory = result;

        })
        .catch(error => console.log('error', error));
    },
    data: function() {
      return {
        localizationHistory: [],
        showModal: false
      }
    },
    props: {
        actualCar: Number
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

        fetch(`http://marcin.innome.pl:8000/localization_history/`, requestOptions)
        .then(response => response.json())
        .then((result) => {
          this.localizationHistory = result;
        })
        .catch(error => console.log('error', error));
      }
    }
}
</script>

<style>

  .localization-history {
    
    color: white;
    height: 100%;
    overflow: auto;
  }

  .action-table {
    height: 80%;
    overflow: auto;
  }
</style>
