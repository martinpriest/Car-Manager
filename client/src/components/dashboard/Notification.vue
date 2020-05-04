<template>
    <div class="notification-box">
        <table>
            <thead>
            <tr>
                <th>Car ID</th>
                <th>Type</th>
                <th>Description</th>
                <th>Date</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="notification in notifications" :key ="notification.id">
                <td>{{notification.idCar}}</td>
                <td>{{notification.notificationType}}</td>
                <td>{{notification.description}}</td>
                <td>{{notification.notificationDate.date}}</td>
                <td>{{notification.status}}</td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        name: 'Notification',
        props: {
            cars: Array
        },
        data: function() {
            return {
                notifications: []
            }
        },
        created: function() {
            var requestOptions = {
                method: 'GET',
                redirect: 'follow',
                credentials: 'include'
            };

            fetch("http://marcin.innome.pl:8000/notification", requestOptions)
                .then(response => response.json())
                .then((result) => {
                    this.notifications = result;
                })
                .catch(error => console.log('error', error));
        },
        methods: {
        }
    }
</script>

<style>
.notification-box {
    color: #fff;
}
</style>