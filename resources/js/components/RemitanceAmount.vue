<template>
  <div class="row mb-3">
    <div class="col-md-6">
      <div class="border bg-info p-3">
        <div class="d-flex justify-content-between">
          <h4 class="text-white">Remitance</h4>
          <h4 class="text-white">{{total}}</h4>
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <input
                type="text"
                placeholder="Amount"
                class="form-control"
                name="amount"
                v-model="amount"
                required
                autocomplete="amount"
              />
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <input
                type="date"
                class="form-control"
                name="payment_date"
                required
                autocomplete="payment_date"
                v-model="date"
              />
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="border bg-secondary p-3">
        <h5 class="text-white">Incentive Payment</h5>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <input
                type="text"
                placeholder="Incentive Amount"
                class="form-control"
                name="incentive_amount"
                v-model="incentive"
              />
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <input type="date" class="form-control" name="incentive_date" />
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- <div class="d-none">{{incentiveC}}</div> -->
  </div>
</template>

<script>
export default {
  props:['percent'],
  data() {
    return {
      amount: "",
      incentive: "",
      date: new Date().toISOString().slice(0, 10)
    };
  },
  methods: {
    calc(num) {
      return num.toString().match(/^-?\d+(?:\.\d{0,2})?/)[0];
    }
  },
  watch: {
    amount(val, newValue) {
      let num = parseFloat(this.amount) || 0;
      this.incentive = this.calc(num * (this.percent/100));
    }
  },
  computed: {
    total() {
      let num = parseFloat(this.amount) || 0;
      let incent = parseFloat(this.incentive) || 0;
      return num + incent > 0 ? this.calc(num + incent) : "";
    }
  }
};
</script>

