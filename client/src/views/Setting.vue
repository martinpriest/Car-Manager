<template>
  <div class="mx-auto">
    <b-tabs content-class="mt-3" fill class="car-profile-box">
    <b-tab title="Profile setting" active>

      <UserSetting/>

    </b-tab>
    <b-tab title="Car groups">
      <CarGroups/>

    </b-tab>
    <b-tab title="App setting">
      <AppSetting/>

    </b-tab>
  </b-tabs>
  </div>
</template>

<script>
import UserSetting from './../components/setting/UserSetting'
import CarGroups from './../components/setting/CarGroups'
import AppSetting from './../components/setting/AppSetting'

export default {

    name: 'Setting',
    components: {
      UserSetting,
      CarGroups,
      AppSetting
    },
    data() {
      return {}
    }
}
</script>

<style>

</style>
