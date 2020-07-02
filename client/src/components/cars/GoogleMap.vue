<template>
  <div>
    <b-container>
      <!-- SHOW MAPS-->
      <b-row v-if="showMap" class="pt-1">
        <b-col cols="12">
          <GmapMap
            id="mapa"
            :center="{lat:50, lng:20}"
            :zoom="7"
            map-type-id="terrain"
            style="width: 100%; height: 300px"
            @click="mark"
          >
            <GmapMarker
              :key="index"
              v-for="(item, index) in markers"
              :position="getPosition(item)"
              :clickable="true"
              :draggable="true"
              @click="toggleInfo(item, index)"
            />
          </GmapMap>
        </b-col>
      </b-row>
      <!-- SHOW ADD LOCALIZATION FORM -->
      <b-row v-if="showAddLocalizationForm" class="pt-1">
        <b-col cols="12">
          <h3>Add localization</h3>
          <b-form-input v-model="addLocalizationForm.description" placeholder="Type description"></b-form-input>
        </b-col>
        <b-col cols="6">
          <b-form-input v-model="clickedLocalization[0].lat" placeholder="Start lat"></b-form-input>
        </b-col>
        <b-col cols="6">
          <b-form-input v-model="clickedLocalization[0].lng" placeholder="Start lng"></b-form-input>
        </b-col>
        <b-col cols="6">
          <b-form-input v-model="clickedLocalization[1].lat" placeholder="End lat"></b-form-input>
        </b-col>
        <b-col cols="6">
          <b-form-input v-model="clickedLocalization[1].lng" placeholder="End lng"></b-form-input>
        </b-col>
        <b-col cols="12">
          <b-form-input v-model="addLocalizationForm.distance" placeholder="Distance"></b-form-input>
        </b-col>
        <b-col cols="12">
          <b-form-input v-model="addLocalizationForm.date" type="date" placeholder></b-form-input>
          <b-button variant="success" @click="addLocalizationHistory">Add localization</b-button>
          <b-button variant="danger" @click="hideForms">Close</b-button>
        </b-col>
      </b-row>

      <!-- SHOW ADD TANK FORM -->
      <b-row v-if="showAddTankForm">
        <!-- Petrol station input -->
        <!-- CAR NAME -->
        <b-row class="pt-1">
          <b-col cols="4">Petrol station:</b-col>
          <b-col cols="8">
            <b-form-input v-model="addTankForm.petrolStation">{{addTankForm.petrolStation}}</b-form-input>
          </b-col>
        </b-row>
        <!-- Fuel amount -->
        <b-row class="pt-1">
          <b-col cols="4">Fuel amount:</b-col>
          <b-col cols="8">
            <b-form-input v-model="addTankForm.fuelAmount">{{addTankForm.fuelAmount}}</b-form-input>
          </b-col>
        </b-row>
        <!-- Fuel price -->
        <b-row class="pt-1">
          <b-col cols="4">Fuel price:</b-col>
          <b-col cols="8">
            <b-form-input v-model="addTankForm.priceAmount">{{addTankForm.priceAmount}}</b-form-input>
          </b-col>
        </b-row>

        <!-- Petrol type select-->
        <b-row class="pt-1">
          <b-col cols="4">Petrol type:</b-col>
          <b-col cols="8">
            <PetrolTypeSelect
              v-bind:actualPetrolType="actualPetrolType"
              @petrolTypeId="updatePetrolId"
            />
          </b-col>
        </b-row>

        <!-- Currency select-->
        <b-row class="pt-1">
          <b-col cols="4">Currency:</b-col>
          <b-col cols="8">
            <CurrencySelect v-bind:actualCurrency="actualCurrency" @tempCurrency="updateCurrency" />
          </b-col>
        </b-row>
        <b-col class="pt-1" cols="12">
          <b-form-input v-model="addTankForm.date" type="date" placeholder></b-form-input>
          <b-button variant="success" @click="addTankHistory">Confirm</b-button>
          <b-button variant="danger" @click="hideForms">Close</b-button>
        </b-col>
      </b-row>

      <!-- SHOW ADD REPAIR FORM -->
      <b-row v-if="showRepairForm">
          <!-- DESCRIPTION -->
        <b-row class="pt-1">
          <b-col cols="4">Description:</b-col>
          <b-col cols="8">
            <b-form-input v-model="addRepairForm.description">{{addRepairForm.description}}</b-form-input>
          </b-col>
        </b-row>

        <!-- Price -->
        <b-row class="pt-1">
          <b-col cols="4">Price:</b-col>
          <b-col cols="8">
            <b-form-input v-model="addRepairForm.amount">{{addRepairForm.amount}}</b-form-input>
          </b-col>
        </b-row>

        <!-- Currency select-->
        <b-row class="pt-1">
          <b-col cols="4">Currency:</b-col>
          <b-col cols="8">
            <CurrencySelect v-bind:actualCurrency="actualCurrency" @tempCurrency="updateCurrency" />
          </b-col>
        </b-row>
        <b-col class="pt-1" cols="12">
          <b-form-input v-model="addRepairForm.date" type="date" placeholder></b-form-input>
          <b-button variant="success" @click="addRepairHistory">Confirm</b-button>
          <b-button variant="danger" @click="hideForms">Close</b-button>
        </b-col>
      </b-row>
      <!-- BOTTOM BUTTONS -->
      <b-row>
        <!-- ADD LOCALIZATION -->
        <b-col cols="4">
          <b-button @click="addLocalization">Add localization</b-button>
        </b-col>
        <!-- ADD TANK -->
        <b-col cols="4">
          <b-button @click="addTank">Add tank</b-button>
        </b-col>
        <!-- ADD REPAIR -->
        <b-col cols="4">
          <b-button @click="addRepair">Add repair</b-button>
        </b-col>
      </b-row>
      <b-row>
        <b-col cols="12">Tooltip message: {{this.tooltipMessage}}</b-col>
      </b-row>
    </b-container>
  </div>
</template>
<script>
// import AddLocalizationHistory from './LocalizationHistory/AddLocalizationHistory'
import PetrolTypeSelect from "./../reusable/PetrolTypeSelect";
import CurrencySelect from "./../reusable/CurrencySelect";
export default {
  name: "GoogleMap",
  props: {
    actualCar: Number
  },
  components: { PetrolTypeSelect, CurrencySelect },
  data() {
    return {
      markers: [
      ],
      clickedLocalization: [
        { lat: 0, lng: 0 },
        { lat: 0, lng: 0 }
      ],
      addLocalizationForm: {
        idCar: 1,
        startLat: -25.344,
        startLng: 131.036,
        endLat: -25.344,
        endLng: 131.036,
        distance: 170,
        description: "",
        date: "20-04-2020"
      },
      addTankForm: {
        idCar: 1,
        idPetrolType: 1,
        petrolStation: "Orlen",
        fuelAmount: 20,
        priceAmount: 3,
        exchangeRate: 1,
        currency: "PLN",
        description: "New record",
        lng: 1,
        lat: 1,
        date: "20-04-2020"
      },
      addRepairForm: {
        idCar: 1,
        amount: 20,
        currency: "PLN",
        exchangeRate: 20,
        description: "Wymiana sprzegla",
        lng: 1,
        lat: 1,
        date: "20-04-2020"
      },
      showMap: true,
      showMapTooltip: false,
      showAddLocalizationForm: false,
      showAddTankForm: false,
      showRepairForm: false,
      tooltipMessage: "No action",
      clickCounter: 0
    };
  },
  created() {
    
  },
  methods: {
    getPosition(marker) {
      return {
        lat: parseFloat(marker.lat),
        lng: parseFloat(marker.lng)
      };
    },
    mark(event) {
      if (localStorage.getItem("activeAction") == 1) {
        if (this.clickCounter == 0) {
          this.clickedLocalization[0] = {
            lat: event.latLng.lat().toFixed(4),
            lng: event.latLng.lng().toFixed(4)
          };
          this.markers.push(this.clickedLocalization[0]);
        } else if (this.clickCounter == 1) {
          this.clickedLocalization[1] = {
            lat: event.latLng.lat().toFixed(4),
            lng: event.latLng.lng().toFixed(4)
          };
          this.markers.push(this.clickedLocalization[1]);
          localStorage.setItem("activeAction", 0);
        }
      }
    },
    toggleInfo(marker, key) {
      this.infoPosition = this.getPosition(marker);
      this.infoContent = marker.full_name;
      // console.log(marker.full_name)
      if (this.infoCurrentKey == key) {
        this.infoOpened = !this.infoOpened;
      } else {
        this.infoOpened = true;
        this.infoCurrentKey = key;
      }
    },
    addLocalization() {
      this.showMapTooltip = true;
      localStorage.setItem("activeAction", 1);

      this.tooltipMessage = "Add first marker";
      var mapa = document.getElementById("mapa");

      this.clickCounter = 0;

      var captureFirstClick = () => {
        this.clickCounter++;
        if (this.clickCounter == 1) {
          this.tooltipMessage = "Add second marker";
        } else if (this.clickCounter == 2) {
          this.tooltipMessage = "Fill a form and confirm";
          this.showMap = false;
          this.showAddLocalizationForm = true;
          mapa.removeEventListener("click", captureFirstClick, false);
        } else {
          this.clickCounter = 0;
        }
      };
      mapa.addEventListener("click", captureFirstClick, false);
    },
    addLocalizationHistory() {
      var json = {
        idCar: this.actualCar,
        startLat: this.clickedLocalization[0].lat,
        startLng: this.clickedLocalization[0].lng,
        endLat: this.clickedLocalization[1].lat,
        endLng: this.clickedLocalization[1].lng,
        distance: parseInt(this.addLocalizationForm.distance),
        description: this.addLocalizationForm.description,
        date: this.addLocalizationForm.date
      };

      var requestOptions = {
        method: "POST",
        body: JSON.stringify(json),
        redirect: "follow",
        credentials: "include"
      };

      fetch(
        `${process.env.VUE_APP_API_URL}/localization_history/create`,
        requestOptions
      )
        .then(response => response.json())
        .then(result => {
          alert(result.message);
          this.showMap = true;
          this.tooltipMessage = "No action";
          this.showAddLocalizationForm = false;
        })
        .catch(() => {
          alert("Cos nie poszlo");
        });
    },
    addTank() {
      this.showMapTooltip = true;
      localStorage.setItem("activeAction", 2);

      this.tooltipMessage = "Choose tank station place";
      var mapa = document.getElementById("mapa");

      this.clickCounter = 0;

      var captureFirstClick = () => {
        this.clickCounter++;
        if (this.clickCounter == 1) {
          this.tooltipMessage = "Fill the form";
          this.showMap = false;
          this.showAddTankForm = true;
          mapa.removeEventListener("click", captureFirstClick, false);
        } else {
          this.clickCounter = 0;
        }
      };
      mapa.addEventListener("click", captureFirstClick, false);
    },
    addTankHistory() {

        this.addTankForm.idCar = this.actualCar;
      var requestOptions = {
        method: "POST",
        body: JSON.stringify(this.addTankForm),
        redirect: "follow",
        credentials: "include"
      };

      fetch(
        `${process.env.VUE_APP_API_URL}/tank_history/create`,
        requestOptions
      )
        .then(response => response.json())
        .then(result => {
          alert(result.message);
          this.showMap = true;
          this.tooltipMessage = "No action";
          this.showAddTankForm = false;
        })
        .catch(() => {
          alert("Cos nie poszlo");
        });
    },
    addRepair() {
    this.showMapTooltip = true;
      localStorage.setItem("activeAction", 3);

      this.tooltipMessage = "Choose your mechanic";
      var mapa = document.getElementById("mapa");

      this.clickCounter = 0;

      var captureFirstClick = () => {
        this.clickCounter++;
        if (this.clickCounter == 1) {
          this.tooltipMessage = "Fill the form";
          this.showMap = false;
          this.showRepairForm = true;
          mapa.removeEventListener("click", captureFirstClick, false);
        } else {
          this.clickCounter = 0;
        }
      };
      mapa.addEventListener("click", captureFirstClick, false);
    },
    addRepairHistory() {

        this.addRepairForm.idCar = this.actualCar;
      var requestOptions = {
        method: "POST",
        body: JSON.stringify(this.addRepairForm),
        redirect: "follow",
        credentials: "include"
      };

      fetch(
        `${process.env.VUE_APP_API_URL}/repair_history/create`,
        requestOptions
      )
        .then(response => response.json())
        .then(result => {
          alert(result.message);
          this.showMap = true;
          this.tooltipMessage = "No action";
          this.showRepairForm = false;
        })
        .catch(() => {
          alert("Cos nie poszlo");
        });
    },

    updatePetrolId: function(petrolTypeId) {
      this.addTankForm.idPetrolType = petrolTypeId;
    },
    updateCurrency: function(tempCurrency) {
      this.addTankForm.currency = tempCurrency.code;
      this.addTankForm.exchangeRate = tempCurrency.mid;

      this.addRepairForm.currency = tempCurrency.code;
      this.addRepairForm.exchangeRate = tempCurrency.mid;
      
    },
    hideForms() {
        this.showMap = true;
        this.showAddLocalizationForm = false;
        this.showAddTankForm = false;
        this.showRepairForm = false;

    }
  }
};
</script>

<style>
</style>