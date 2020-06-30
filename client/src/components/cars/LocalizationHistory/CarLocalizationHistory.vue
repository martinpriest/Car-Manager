<template>
  <div class="car-profile-box">
      <span>Localization History</span>
      <div class="action-table">
      <LocalizationHistoryTable v-bind:localizationHistory="localizationHistory"/>
      </div>
      <AddLocalizationHistory v-bind:actualCar="actualCar" v-if="showModal" @close="showModal = false"/>
      <button class="btn btn-success w-50 m-auto" id="show-localization-modal" @click="showModal = true">Add localization</button>
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
    beforeCreated: function() {
        var json = {
          idCar: this.actualCar
        };

        var requestOptions = {
          method: 'POST',
          body: JSON.stringify(json),
          redirect: 'follow',
          credentials: 'include'
        };

        fetch(`${process.env.VUE_APP_API_URL}/localization_history/`, requestOptions)
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

        fetch(`${process.env.VUE_APP_API_URL}/localization_history/`, requestOptions)
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
</style>
