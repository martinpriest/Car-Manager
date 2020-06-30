<template>
<div>
    <transition name="modal">
        <div class="modal-mask">
          <div class="modal-wrapper">
            <div class="modal-container">

              <div class="modal-header">
                <slot name="header">
                  default header
                </slot>
              </div>

              <div class="adding-box form-group">
                <input class="form-control w-100" v-model="name" type="text" placeholder="Enter car's name">
                <input class="form-control w-100" v-model="mark" type="text" placeholder="Enter car's brand">
                <input class="form-control w-100" v-model="model" type="text" placeholder="Enter car's model">
                <input class="form-control w-100" type="color" v-model="color" name="favcolor" value="#ff0000">
                <input class="form-control w-100" v-model="engineMileage" type="number" placeholder="Mileage" value="10000">
              </div>

              <div class="modal-footer">
                <slot name="footer">
                  <button class="btn btn-danger" @click="$emit('close')">
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
</div>

</template>

<script>
export default {
    name: 'AddCarModal',
    data: function() {
        return {
            name: "",
            mark: "",
            model: "",
            color: "",
            engineMileage: ""
        }
    },
    methods: {
      addCar() {
         var json = {
                idCarGroup: 1,
                name: this.name,
                mark: this.mark,
                year: 2020,
                model: this.model,
                hexColor: this.color,
                engineMileage: parseInt(this.engineMileage)
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
              this.$emit('close')
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
