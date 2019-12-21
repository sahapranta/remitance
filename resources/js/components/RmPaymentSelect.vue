<template>
  <div class="row">
    <div class="col-6">
      <div class="form-group">
        <select
          placeholder="Payment By"
          class="form-control"
          :class="payment_by_error"
          name="payment_by"
          v-model="payment_by"
          required
        >
          <option value="branch">Branch | Payment By</option>
          <option value="agent">Agent | Payment By</option>
        </select>
        <slot name="payment_by"></slot>
      </div>
    </div>
    <div class="col-6">
      <div class="form-group">
        <select
          class="form-control"
          name="payment_type"
          v-model="payment_type"
          :class="payment_type_error"
        >
          <option value="cash">Cash | Payment Type</option>
          <option value="transfer">Transfer | Payment Type</option>
        </select>
        <slot name="payment_type"></slot>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["predata"],
  data() {
    return {
      payment_by: "",
      payment_type: ""
    };
  },
  mounted() {
    if (this.predata) {
      (this.payment_by = this.predata[0]),
        (this.payment_type = this.predata[1]);
    }
  },
  computed: {
    payment_by_error() {
      return !!this.$slots.payment_by ? "is-invalid" : "";
    },
    payment_type_error() {
      return !!this.$slots.payment_type ? "is-invalid" : "";
    }
  }
};
</script>
