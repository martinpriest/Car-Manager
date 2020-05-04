<template>
    <div>
        <transition name="modal">
        <div class="modal-mask">
          <div class="modal-wrapper">
            <div class="modal-container">
 
              <div class="modal-header">
                <slot name="header">
                  Add repair
                </slot>
              </div>
 
              <div class="modal-body">
                <slot name="body">
                  <SelectCurrency v-bind:actualCurrency="actualCurrency" @tempCurrency="updateCurrency"/>
                  <input class="form-control w-100" v-model="amount" type="number" placeholder="Amount">
                  <input class="form-control w-100" v-model="description" type="text" placeholder="Descrption">
                  <input class="form-control w-100" v-model="date" type="date">
                </slot>
              </div>
 
              <div class="modal-footer">
                <slot name="footer">
                  <button class="btn btn-danger" @click="$emit('close')">
                    Close
                  </button>
                  <button class="btn btn-success" @click="addRepair()">
                    Add repair
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
import SelectCurrency from './SelectCurrency'
export default {
    name: 'AddRepairHistory',
    data: function() {
        return {
            idCar: this.actualCar,
            actualCurrency: {
              code: String,
              mid: Number
            },
            date: "2020-10-05",
            amount: Number,
            description: "Default desc",
            showModal: false
        }
    },
    components: {
        SelectCurrency
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
        addRepair: function() {

            var json = {
                idCar: this.idCar,
                date: this.date,
                amount: parseInt(this.amount),
                exchangeRate: this.actualCurrency.mid,
                currency: this.actualCurrency.code,
                description: this.description
            };

            var requestOptions = {
                method: 'POST',
                body: JSON.stringify(json),
                redirect: 'follow',
                credentials: 'include'
            };

            fetch("http://marcin.innome.pl:8000/repair_history/create", requestOptions)
            .then(response => response.json())
            .then((result) => {
              alert(result.message);
              this.$emit('close')
            })
            .catch(error => console.log('error', error));
        },
        updateCurrency: function(tempCurrency) {
          this.actualCurrency.code = tempCurrency.code;
          this.actualCurrency.mid = tempCurrency.mid;
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