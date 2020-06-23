<template>
  <div>
    <b-alert :show="showAlert">
      Get the Voucher
      <a :href="alertData">Print</a>
    </b-alert>
    <div class="row">
      <div class="col-md-6">
        <b-table hover :items="items" selectable @row-selected="onRowSelected" responsive="sm"></b-table>
      </div>
      <div class="col-md-6">
        <b-table
          hover
          :items="selected_row"
          :fields="['incentive_date', 'incentive_amount']"
          responsive="sm"
        >
          <template v-slot:cell(incentive_date)="row">
            <input
              type="date"
              class="form-control form-control-sm"
              v-model="selected_row[row.index].incentive_date"
            />
          </template>
          <template v-slot:cell(incentive_amount)="row">
            <input
              type="text"
              class="form-control form-control-sm"
              v-model="selected_row[row.index].incentive_amount"
            />
          </template>
        </b-table>
        <h4 v-if="selected_row.length" class="float-right mr-3 border-bottom text-danger">
          <b>Total:</b>
          {{total}}
        </h4>
      </div>
    </div>
    <b-button variant="dark" class="col-md-3">Back</b-button>
    <b-button
      variant="success"
      class="col-md-4"
      @click="submit"
      :disabled="selected_row.length > 0 ? false:true"
    >Submit</b-button>
  </div>
</template>

<script>
export default {
  props: ["remitances", "customer"],
  data() {
    return {
      selected_row: [],
      fields: ["id", "reference", "amount"],
      showAlert: false,
      alertData: ""
    };
  },
  methods: {
    remove_row(e) {
      let data = this.remitances;
      e.target.parentNode.parentNode.classList.add("bg-secondary");
      data.filter(d => !d.id === e.target.id);
      this.selected_row = [...data];
    },
    calc(num) {
      return num.toString().match(/^-?\d+(?:\.\d{0,2})?/)[0];
    },
    pluck(array, key) {
      return array.map((item, i) => {
        let u = {};
        key.forEach(key => (u[key] = item[key]));
        return u;
      });
    },
    onRowSelected(item) {
      this.selected_row = item.map(it => {
        return {
          id: it.id,
          incentive_date: new Date().toISOString().slice(0, 10),
          incentive_amount: (it.amount * 0.02).toFixedNoRounding(2)
        };
      });
    },
    submit() {
      axios
        .post(`/remitance/${this.customer}/payall`, {
          data: this.selected_row
        })
        .then(res => {
          if (res.status === 201 || res.status === 200) {
            this.$bvToast.toast(
              `${this.selected_row.length} Incentive paid of total ${this.total}tk`,
              {
                title: `Submitted Successfully`,
                variant: "warning",
                solid: true
              }
            );
            this.showAlert = true;
            let ids = this.selected_row.map(row => row.id);
            this.alertData = `/report/incentive/${this.customer}?data=${res.data}`;           
          }
        })
        .catch(err => console.log(err));
    }
  },
  computed: {
    items() {
      return this.pluck(this.remitances, this.fields);
    },
    total() {
      return this.selected_row
        .reduce((ac, r) => ac + parseFloat(r.incentive_amount), 0)
        .toFixed(2);
    }
  }
};
</script>
