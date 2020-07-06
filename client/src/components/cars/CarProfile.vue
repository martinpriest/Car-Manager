<template>
  <div>
    <b-container>
      <b-form @submit="onSubmit" v-if="show">
        <!-- CAR IMAGE -->
        <b-row class="pt-1">
          <b-col cols="12">
            <img src="./../../assets/car-default.svg" alt="Car image" />
          </b-col>
        </b-row>
        <!-- CAR NAME -->
        <b-row class="pt-1">
          <b-col cols="4">Name:</b-col>
          <b-col cols="8">
            <b-form-input id="car-profile-name" v-model="name">{{name}}</b-form-input>
          </b-col>
        </b-row>
        <!-- MARK -->
        <b-row class="pt-1">
          <b-col cols="4">Mark:</b-col>
          <b-col cols="8">
            <b-form-input id="car-profile-mark" v-model="mark">{{mark}}</b-form-input>
          </b-col>
        </b-row>
        <!-- MODEL -->
        <b-row class="pt-1">
          <b-col cols="4">Model:</b-col>
          <b-col cols="8">
            <b-form-input id="car-profile-model" v-model="model">{{model}}</b-form-input>
          </b-col>
        </b-row>
        <!-- YEAR -->
        <b-row class="pt-1">
          <b-col cols="4">Year:</b-col>
          <b-col cols="8">
            <b-form-input id="car-profile-year" v-model="year" type="number">{{year}}</b-form-input>
          </b-col>
        </b-row>
        <!-- Car group: -->
        <b-row class="pt-1">
          <b-col cols="4">Car group:</b-col>
          <b-col cols="8">
            <b-form-select
              placeholder="Choose group"
              v-model="carGroup.id"
              :options="carGroupOptions"
              @change="pickCarGroup($event)"
            ></b-form-select>
          </b-col>
        </b-row>
        <!-- ENGINE MILEAGE -->
        <b-row class="pt-1">
          <b-col cols="4">Mileage:</b-col>
          <b-col cols="8">
            <b-form-input
              id="car-profile-engine-mileage"
              v-model="engineMileage"
              type="number"
            >{{year}}</b-form-input>
          </b-col>
        </b-row>
        <!-- COLOR -->
        <b-row class="pt-1">
          <b-col cols="4">Color:</b-col>
          <b-col cols="8">
            <b-form-input id="car-profile-hex-color" v-model="hexColor" type="color"></b-form-input>
          </b-col>
        </b-row>
        <!-- PUBLIC STATUS -->
        <b-row class="pt-1">
          <b-col cols="4">Public:</b-col>
          <b-col cols="8">
            <b-form-checkbox
              id="car-profile-is-public"
              v-model="isPublic"
              name="car-profile-is-public"
            ></b-form-checkbox>
          </b-col>
        </b-row>
        <b-row class="pt-1">
          <b-col cols="6">
            <b-button
              id="edit-profile-button"
              variant="success"
              @click="editCar"
            >Change</b-button>
          </b-col>
          <b-col cols="6">
        <b-button variant="danger" @click="deleteCar">Delete car</b-button>
          </b-col>
        </b-row>
      </b-form>
    </b-container>
  </div>
</template>

<script>
export default {
  name: "CarProfile",
  data: function() {
    return {
      selectedCarGroup: null,
      carGroupOptions: [],
      name: "",
      carGroup: {
        id: "",
        name: ""
      },
      mark: "",
      model: "",
      year: "",
      isPublic: "",
      hexColor: "#aaaaaa",
      engineMileage: "",
      show: true,
    };
  },
  props: {
    actualCar: Number
  },
  methods: {
    deleteCar() {
      var requestOptions = {
        method: "DELETE",
        redirect: "follow",
        credentials: "include"
      };

      fetch(`${process.env.VUE_APP_API_URL}/car/${this.actualCar}`, requestOptions)
        .then(response => response.json())
        .then(result => {
          alert(result.message);
          location.reload();
        })
        .catch(error => console.log("error", error));
    },
    pickCarGroup(event) {
      this.carGroup.id = event;
    },
    onSubmit(evt) {
      evt.preventDefault();
      alert(JSON.stringify(this.form));
    },
    editCar() {
      
      var json = {
        idCarGroup: this.carGroup.id,
        name: this.name,
        mark: this.mark,
        year: this.year,
        model: this.model,
        hexColor: this.hexColor,
        engineMileage: parseInt(this.engineMileage).actualCar,
        isPublic: this.isPublic
      };

      var requestOptions = {
        method: "PUT",
        body: JSON.stringify(json),
        redirect: "follow",
        credentials: "include"
      };

      fetch(`${process.env.VUE_APP_API_URL}/car/${this.actualCar}`, requestOptions)
        .then(response => response.json())
        .then(result => {
          document.querySelector("#dropdown-left__BV_toggle_").textContent = this.name;
          alert(result.message);
        })
        .catch(error => console.log("error", error));
    }
  },
  created() {
    var requestOptions = {
          method: 'GET',
          redirect: 'follow',
          credentials: 'include'
        };
    fetch(`${process.env.VUE_APP_API_URL}/car_group/`, requestOptions)
        .then(response => response.json())
        .then((carGroups) => {
          this.carGroup.id = carGroups[0].id;
          this.carGroup.name = carGroups[0].name;
          carGroups.forEach((carGroup) => {
            this.carGroupOptions.push({value: carGroup.id, text: carGroup.name})
          })
        })
        .catch(error => console.log('error', error));
  },
  watch: {
    actualCar: function() {
      var requestOptions = {
        method: "GET",
        redirect: "follow",
        credentials: "include"
      };

      fetch(
        `${process.env.VUE_APP_API_URL}/car/${this.actualCar}`,
        requestOptions
      )
        .then(response => response.json())
        .then(result => {
          this.name = result.name;
          this.isPublic = result.isPublic;
          this.mark = result.mark;
          this.year = parseInt(result.year);
          this.model = result.model;
          this.hexColor = result.hexColor;
          this.engineMileage = result.engineMileage;
          this.carGroup.id = result.idCarGroup;
          this.carGroup.name = result.carGroupName;

        })
        .catch(error => console.log("error", error));
    }
  }
};
</script>

<style>
</style>