<template>
  <div>
    <b-form-select id="notificationSelect" v-model="selected" :options="options" @change="pickNotificationType($event)"></b-form-select>
  </div>
</template>

<script>
export default {
    name: 'NotificationTypeSelect',
    data: function() {
        return {
            selected: 1,
            options: []
        }
    },
    created: function() {
        var requestOptions = {
          method: 'GET',
          redirect: 'follow',
          credentials: 'include'
        };

        fetch(`${process.env.VUE_APP_API_URL}/notification_types/`, requestOptions)
        .then(response => response.json())
        .then((result) => {
          result.forEach((type) => {
              this.options.push({value: type.id, text: type.name})
          })
        })
        .catch(error => console.log('error', error));
    },
    methods: {
      pickNotificationType(event) {
          console.log(`EMITOWALEM ${event}`)
        this.$emit("notificationType", event);
      }
    }
}
</script>

<style>

</style>