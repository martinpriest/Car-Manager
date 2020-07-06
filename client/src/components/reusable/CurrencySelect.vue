<template>
<div>
<select class="form-control w-100" name="currency-type" id="currency-type" v-model="actualCurrency" @change="pickCurrency()">
    <option v-for="record in currency" :value="{mid: record.mid, code: record.code}" :key ="record.id">{{record.code}}</option>
</select>
</div>

</template>

<script>
export default {
    name: 'CurrencySelect',
    data: function() {
        return {
          actualCurrency: {
            code: "PLN",
            mid: 1,
          },
          currency: [],
        }
    },
    props: {
    },
    created: function() {
        var requestOptions = {
          method: 'GET',
          redirect: 'follow'
        };

        fetch("https://api.nbp.pl/api/exchangerates/tables/A/?format=json", requestOptions)
        .then(response => response.json())
        .then((result) => {
          this.currency = result[0].rates;
        this.currency.push({currency: "polski złoty", code: "PLN", mid: 1})
        })
        .catch(error => console.log('error', error));
    },
    methods: {
      pickCurrency() {
        let tempCurrency = {
          code: this.actualCurrency.code,
          mid: this.actualCurrency.mid,
        }
        this.$emit("tempCurrency", tempCurrency);
      }
    }
}
</script>

<style>

</style>