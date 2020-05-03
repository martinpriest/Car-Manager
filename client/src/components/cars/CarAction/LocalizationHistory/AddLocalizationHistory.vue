<template>
  <div>
      <transition name="modal" @close="showModal = false">
        <div class="modal-mask">
          <div class="modal-wrapper">
            <div class="modal-container">

              <div class="modal-header">
                <slot name="header">
                  Dodaj lokalizacje
                </slot>
              </div>

              <div class="modal-body">
                <slot name="body">
                  <input v-model="startLocalizationLink" type="text" placeholder="Google maps link1">
                  <input v-model="endLocalizationLink" type="text" placeholder="Google maps link2">
                  <input v-model="startLocalizationName" type="text" placeholder="Start location">
                  <input v-model="endLocalizationName" type="text" placeholder="End location">
                  <input v-model="distance" type="number" placeholder="Google maps link1">
                  <input v-model="description" type="text" placeholder="Google maps link1">
                  <input v-model="date" type="date" placeholder="">
                </slot>
              </div>

              <div class="modal-footer">
                <slot name="footer">
                  <button class="modal-default-button" @click="addLocalizationHistory">
                    Add
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
    name: 'AddLocalizationHistory',
    props: {
      actualCar: Number
    },
    data: function() {
        return {
            startLocalizationLink: "",
            endLocalizationLink: "",
            startLocalizationName: "",
            endLocalizationName: "",
            distance: 0,
            description: "Default",
            date: "2020-05-05",
            showModal: false
        }
    },
    methods: {
        addLocalizationHistory() {
            var json = {
                idCar: this.actualCar,
                startLocalizationLink: this.startLocalizationLink,
                endLocalizationLink: this.endLocalizationLink,
                startLocalizationName: this.startLocalizationName,
                endLocalizationName: this.endLocalizationName,
                distance: parseInt(this.distance),
                description: this.description,
                date: this.date,
            };

            console.log("Add localization history body ")
            console.log(json)

            var requestOptions = {
                method: 'POST',
                body: JSON.stringify(json),
                redirect: 'follow',
                credentials: 'include'
            };

            fetch("http://marcin.innome.pl:8000/localization_history/create", requestOptions)
            .then(response => response.json())
            .then((result) => {
              alert(result.message);
              this.$emit('close')
            })
            .catch(() => {
              alert('Cos nie poszlo')
              this.$emit('close')
            });
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
