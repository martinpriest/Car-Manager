<template>
    <div>
        <transition name="modal">
        <div class="modal-mask">
          <div class="modal-wrapper">
            <div class="modal-container">
 
              <div class="modal-header">
                <slot name="header">
                  Add tank
                </slot>
              </div>
 
              <div class="modal-body">
                <slot name="body">
                  <input id="" class="form-control" type="text" placeholder="Petrol station">
                  <SelectPetrolType/>
                  <input type="text" placeholder="Amount">
                  <input type="text" placeholder="Price">
                  <input type="text" placeholder="Currency">
                  <input type="text" placeholder="Descrption">
                  <input type="text" placeholder="Petrol type">
                  <input type="text" placeholder="Exchange rate">
                  <input type="date">
                </slot>
              </div>
 
              <div class="modal-footer">
                <slot name="footer">
                  default footer
                  <!-- <button class="modal-default-button" @click="$emit('close')"> -->
                      
                  <button class="modal-default-button" @click="addTank()">
                    OK
                  </button>
                </slot>
              </div>
            </div>
          </div>
        </div>
      </transition>
    </div>
</template>

<script>
import SelectPetrolType from './SelectPetrolType'
export default {
    name: 'AddTankHistory',
    data: function() {
        return {
            showModal: false
        }
    },
    components: {
        SelectPetrolType
    },
    props: {
        actualCar: Number
    },
    watch: {
        actualCar: function() {
            return this.actualCar;
        }
    },
    methods: {
        addTank: function() {
            let idCar = this.actualCar();
            let idPetrolType = document.querySelector("#idPetrolType");
            let petrolStation = document.querySelector("#petrolStation");
            let date = document.querySelector("#date");
            let fuelAmount = document.querySelector("#fuelAmount");
            let priceAmount = document.querySelector("#priceAmount");
            let exchangeRate = document.querySelector("#exchangeRate");
            let currency = document.querySelector("#currency");
            let description = document.querySelector("#description");

            var json = {
                idCar: idCar,
                idPetrolType: idPetrolType.value,
                petrolStation: petrolStation.value,
                date: date.value,
                fuelAmount: fuelAmount.value,
                priceAmount: priceAmount.value,
                exchangeRate: exchangeRate.value,
                currency: currency.value,
                description: description.value
            };

            var requestOptions = {
                method: 'POST',
                body: JSON.stringify(json),
                redirect: 'follow',
                credentials: 'include'
            };

            fetch("http://marcin.innome.pl:8000/tank_history", requestOptions)
            .then(response => response.json())
            .then((result) => {
            console.log(result);
            this.tankHistory = result;
            // $emit('close')
            })
            .catch(error => console.log('error', error));
        }
    }
}
</script>

<style>
.modal-mask {
  position: fixed;
  z-index: 9998;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: table;
  transition: opacity 0.3s ease;
}
 
.modal-wrapper {
  display: table-cell;
  vertical-align: middle;
}
 
.modal-container {
  width: 300px;
  margin: 0px auto;
  padding: 20px 30px;
  background-color: #fff;
  border-radius: 2px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.33);
  transition: all 0.3s ease;
  font-family: Helvetica, Arial, sans-serif;
}
 
.modal-header h3 {
  margin-top: 0;
  color: #42b983;
}
 
.modal-body {
  margin: 20px 0;
}
 
.modal-default-button {
  float: right;
}
 
/*
 * The following styles are auto-applied to elements with
 * transition="modal" when their visibility is toggled
 * by Vue.js.
 *
 * You can easily play with the modal transition by editing
 * these styles.
 */
 
.modal-enter {
  opacity: 0;
}
 
.modal-leave-active {
  opacity: 0;
}
 
.modal-enter .modal-container,
.modal-leave-active .modal-container {
  -webkit-transform: scale(1.1);
  transform: scale(1.1);
}
</style>