<template>
<div class="car-profile-box" style="max-height: 60px;">
<b-container class="bv-example-row">
    <b-row>
        <b-col cols="6">
            <b-dropdown id="dropdown-left" text="Choose car" variant="primary" class="m-2" menu-class="w-100">
                <b-dropdown-item class="menu-item" v-for="car in cars" :key ="car.id" v-on:click="pickCar(car.id, car.name)">{{car.name}}</b-dropdown-item>
            </b-dropdown>
        </b-col>
        <b-col cols="3">
            <b-button class="m-2" style="font-size: 12px" variant="success" @click="showAddCarForm = true">Add car</b-button>
        </b-col>
  </b-row>
  <transition name="modal" v-if="showAddCarForm">
        <div class="modal-mask">
          <div class="modal-wrapper">
            <div class="modal-container">

              <div class="modal-header">
                <slot name="header" style="color: black">
                  Add new car
                </slot>
              </div>

              <div class="adding-box form-group">
                <input class="form-control w-100" v-model="addCarForm.name" type="text" placeholder="Enter car's name">
                <input class="form-control w-100" v-model="addCarForm.mark" type="text" placeholder="Enter car's brand">
                <input class="form-control w-100" v-model="addCarForm.model" type="text" placeholder="Enter car's model">
                <input class="form-control w-100" type="color" v-model="addCarForm.color" name="favcolor" value="#ff0000">
                <input class="form-control w-100" type="number" v-model="addCarForm.year" placeholder="Type car year" name="favcolor" value="2020">
                <input class="form-control w-100" v-model="addCarForm.engineMileage" type="number" placeholder="Mileage" value="10000">
                <CarGroupSelect @idCarGroup="updateIdCarGroup"/>
              </div>

              <div class="modal-footer">
                <slot name="footer">
                  <button class="btn btn-danger" @click="showAddCarForm = false">
                    Close
                  </button>
                  <button class="btn btn-success" @click="addCar()">
                    Add car
                  </button>
                </slot>
              </div>
            </div>
          </div>
        </div>
      </transition>
</b-container>
</div>
</template>

<script>
import CarGroupSelect from './../reusable/CarGroupSelect'
export default {
    name: 'CarMenu',
    components: {
        CarGroupSelect
    },
    props: {
        cars: Array
    },
    mounted() {
        document.querySelector("#dropdown-left__BV_toggle_").textContent = this.cars[0].name;
    },
    data: function() {
        return {
            showAddCarForm: false,
            addCarForm: {
                idCarGroup: "",
                name: "",
                mark: "",
                model: "",
                color: "",
                engineMileage: "",
                year: 2020
            }
        }
    },
    methods: {
        pickCar(car, name) {
            this.$emit("carId", car);
            this.$emit("carName", name);
            document.querySelector("#dropdown-left__BV_toggle_").textContent = name;
        },
        addCar() {
            var json = {
                idCarGroup: this.addCarForm.idCarGroup,
                name: this.addCarForm.name,
                mark: this.addCarForm.mark,
                year: this.addCarForm.year,
                model: this.addCarForm.model,
                hexColor: this.addCarForm.color,
                engineMileage: parseInt(this.addCarForm.engineMileage)
            };

            var requestOptions = {
                method: 'POST',
                body: JSON.stringify(json),
                redirect: 'follow',
                credentials: 'include'
            };

            fetch(`${process.env.VUE_APP_API_URL}/car/`, requestOptions)
            .then(response => response.json())
            .then((result) => {
              alert(result.message);
              json.id = result.id;
              this.cars.push(json)
                this.$emit("carId", result.id);
              this.showAddCarForm = false;
            })
            .catch(error => console.log('error', error));
        },
        updateIdCarGroup: function(carGroup) {
            this.addCarForm.idCarGroup = parseInt(carGroup);
        }
    }
}
</script>

<style>
</style>
