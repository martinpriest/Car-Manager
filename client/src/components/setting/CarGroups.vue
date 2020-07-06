<template>
  <div>
      <h3>Car groups</h3>
      <b-button class="mb-2" variant="success" @click="addCarGroup">Create Car group</b-button>
      <table class="table table-bordered table-hover table-dark w-75 overflow-auto m-auto">
        <thead>
          <th>Name</th>
          <th>Action</th>
        </thead>
        <tbody>
          <tr v-for="item in carGroups" :key="item.id">
            <td>{{item.name}}</td>
            <td><b-button variant="danger" @click="deleteCarGroup(item)">Delete</b-button></td>
          </tr>
        </tbody>
        <!-- <li v-for="item in carGroups" :key="item.id">
        <b-col cols=12>

        </b-col>
          <b-col cols="6">{{item.name}}</b-col>

          <b-col cols="6">DELETE</b-col>
        </li> -->
      </table>
  </div>
</template>

<script>
export default {
    name: "CarGroups",
    data() {
      return {
        carGroups: [],
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
        .then((result) => {
          result.forEach((carGroup) => {
              this.carGroups.push(carGroup)
          })
        })
        .catch(error => console.log('error', error));
    },
    methods: {
      deleteCarGroup(carGroup) {
        var requestOptions = {
          method: 'DELETE',
          redirect: 'follow',
          credentials: 'include'
        };

        fetch(`${process.env.VUE_APP_API_URL}/car_group/${carGroup.id}`, requestOptions)
        .then(response => response.json())
        .then((response) => {
          if(response.message == "Car group deleted") {
            var index = this.carGroups.map(x => {
              return x.id;
            }).indexOf(carGroup.id);
            this.carGroups.splice(index, 1);
          } else alert(response.message)
        })
        .catch(error => console.log('error', error));
      },
      addCarGroup() {
        var carGroupName = prompt("Car group name: ");
        if(carGroupName) {
            var json = {
                name: carGroupName,
            };

            var requestOptions = {
                method: 'POST',
                body: JSON.stringify(json),
                redirect: 'follow',
                credentials: 'include'
            };

            fetch(`${process.env.VUE_APP_API_URL}/car_group/`, requestOptions)
            .then(response => response.json())
            .then((result) => {
              this.carGroups.push({'id': result.id, 'name': carGroupName})
            })
            .catch(error => console.log('error', error));
        }
      }
    }
}
</script>

<style>

</style>