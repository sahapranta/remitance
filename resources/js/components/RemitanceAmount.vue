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
              >
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
                v-model="payment_date"
              >
            </div>
          </div>
        </div>
        <slot name="remitance"></slot>
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
              >
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <input type="date" class="form-control" :class="incentive_date_error" name="incentive_date" v-model="incentive_date">
              <slot name="incentive"></slot>
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
  props: ["percent", "predata", 'editmode'],
  data() {
    return {
      amount: "",
      incentive: "",      
      payment_date:"",
      incentive_date:""

    };
  },  
  watch: {
    amount(val, newValue) {
      let num = parseFloat(this.amount) || 0;
      if (this.editmode !== 'true') {
        this.incentive = (num * (this.percent / 100)).toFixedNoRounding(2);       
      }
    }
  },
  computed: {
    total() {
      let num = parseFloat(this.amount) || 0;
      let incent = parseFloat(this.incentive) || 0;
      return num + incent > 0 ? (num + incent).toFixedNoRounding(2) : "";
    },
    incentive_date_error(){
       return !!this.$slots.incentive ? 'is-invalid' : '' ;
    }
  },
  mounted(){
    if (this.predata.length>0) {
      this.amount = this.predata[0] || '' ;
      this.incentive = this.predata[1] || '' ;
    }
    if (this.editmode == 'true') {
      this.payment_date = new Date(this.predata[2]).toISOString().slice(0, 10);
      this.incentive_date = new Date(this.predata[3]).toISOString().slice(0, 10);
    } else {      
      this.payment_date = new Date().toISOString().slice(0, 10);
    }
  }
};
</script>

