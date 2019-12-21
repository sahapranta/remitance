<template>
  <div>
    <div class="form-group">
      <div class="input-group">
        <input
          type="text"
          class="form-control"
          placeholder="XLSX Ref..."
          name="excel_ref"
          v-model="reference"
        />
        <div class="input-group-append">
          <button class="btn btn-secondary" @click="submit" :disabled="reference.length<=0">Find</button>
        </div>
      </div>
    </div>
    <b-modal ref="check-record-modal" hide-footer>
      <template v-slot:modal-title>{{modal_header}}</template>
      <div class="d-block text-center" v-if="modal_sate === 'remitance'">
        <h3>{{this.fetched_obj.name }}!</h3>
        <form action="/remitance/prefilled_remitance" method="post">
          <input type="hidden" name="_token" :value="token" />
          <input type="hidden" :value="inputs.sender" name="sender" />
          <input type="hidden" :value="inputs.sending_country" name="sending_country" />
          <input type="hidden" :value="inputs.customer" name="customer" />
          <input type="hidden" :value="inputs.remit_type" name="remit_type" />
          <input type="hidden" :value="inputs.exchange_house" name="exchange_house" />
          <input type="hidden" :value="inputs.reference" name="reference" />
          <input type="hidden" :value="inputs.payment_date" name="payment_date" />
          <input type="hidden" :value="inputs.amount" name="amount" />
          <button type="submit" class="btn btn-danger btn-block mt-3">Add Remitance</button>
        </form>
      </div>
      <div v-else-if="modal_sate === 'customer'">
        <div class="form-group">
          <input
            type="text"
            placeholder="Name"
            class="form-control"
            :class="errors.name?'is-invalid':''"
            name="name"
            required
            v-model="customer.name"
          />
          <span class="invalid-feedback" v-if="errors.name">
                {{errors.name[0]}}
            </span>
        </div>
        <div class="form-group">
          <input
            type="text"
            placeholder="Address"
            class="form-control"
            :class="errors.address?'is-invalid':''"
            v-model="customer.address"
          />
          <span class="invalid-feedback" v-if="errors.address">
                {{errors.address[0]}}
            </span>
        </div>
        <div class="row">
          <div class="col-6">
            <div class="form-group">
              <input
                type="text"
                placeholder="Mobile No."
                class="form-control"
                :class="errors.mobile?'is-invalid':''"
                v-model="customer.mobile"
              />
              <span class="invalid-feedback" v-if="errors.mobile">
                {{errors.mobile[0]}}
            </span>
            </div>
          </div>
          <div class="col-6">
            <div class="form-group">
              <input type="date" class="form-control" :class="errors.birthdate?'is-invalid':''" v-model="customer.birthdate" />
              <span class="invalid-feedback" v-if="errors.birthdate">
                {{errors.birthdate[0]}}
            </span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-4">
            <div class="form-group">
              <input
                type="text"
                placeholder="National ID."
                class="form-control"
                :class="errors.nid?'is-invalid':''"
                v-model="customer.nid"
              />
              <span class="invalid-feedback" v-if="errors.nid">
                {{errors.nid[0]}}
            </span>
            </div>
          </div>
          <div class="col-4">
            <div class="form-group">
              <input
                type="text"
                placeholder="Passport ID."
                class="form-control"
                :class="errors.passport_id?'is-invalid':''"
                v-model="customer.passport_id"
              />
              <span class="invalid-feedback" v-if="errors.passport_id">
                {{errors.passport_id[0]}}
            </span>
            </div>
          </div>
          <div class="col-4">
            <div class="form-group">
              <input
                type="text"
                placeholder="Bank Account ID."
                class="form-control"
                :class="errors.account_id?'is-invalid':''"
                v-model="customer.account_id"
              />
              <span class="invalid-feedback" v-if="errors.account_id">
                {{errors.account_id[0]}}
            </span>
            </div>
          </div>
        </div>
        <button class="btn btn-block btn-success" @click="submitCustomer">Submit</button>
      </div>
      <div class="d-block text-center" v-else>
        <h3 class="text-danger">Reference does not exists in Record!</h3>
        <h5>Type the reference number correctly.</h5>
      </div>
    </b-modal>
  </div>
</template>

<script>
export default {
  props: ["token"],
  data() {
    return {
      customer: {},
      reference: "",
      record: [],
      found_obj: "",
      fetched_obj: "",
      urlToSend: "",
      inputs: "",
      modal_header: "",
      modal_sate: "",
      errors: ""
    };
  },
  mounted() {
    this.getxls();
  },
  methods: {
    submit: function() {
      let ref = this.reference;
      let arr = this.record;

      let found_obj = arr.find(r => r.reference === parseInt(ref));
      if (typeof found_obj == "object") {
        this.found_obj = found_obj;
        this.modal_header = "Found Customer";
        axios
          .post("/remitance/entry", { data: this.found_obj })
          .then(res => {
            if (typeof res.data == "object") {
              this.fetched_obj = res.data;
              this.inputs = this.createUrl(found_obj, this.fetched_obj.id);
              this.modal_sate = "remitance";
              this.openModal();
            }
          })
          .catch(err => {
            this.$bvToast.toast(err.message, {
              title: `Customer Not Found`,
              variant: "danger",
              solid: true
            });
            this.customer = {
                name:this.found_obj.name || "",
                mobile:this.found_obj.mobile || "",
                address:this.found_obj.address || "",
                nid:this.found_obj.nid || "",
            };
            this.modal_header = "Create New Customer";
            this.modal_sate = "customer";
            setTimeout(() => {
              this.openModal();
            }, 1000);
          });
      } else {
        this.modal_header = "Record Not Found";
        this.openModal();
      }
    },
    submitCustomer() {
        this.errors = "";
      axios
        .post("/customer", this.customer)
        .then(res => {
          if (res.status === 200 || res.status === 201) {
            this.fetched_obj = res.data;
            this.inputs = this.createUrl(this.found_obj, this.fetched_obj.id);
            this.modal_sate = "remitance";
            this.openModal();
            this.customer = {};
          }
        })
        .catch(err => {            
         this.errors = err.response.data.errors;
          this.$bvToast.toast(err.message, {
            title: `Customer Not Created`,
            variant: "danger",
            solid: true
          });
        });
    },
    getxls: function() {
      var url = "/file/remitance.xlsx";
      axios
        .get(url, {
          responseType: "arraybuffer"
        })
        .then(res => {
          var data = new Uint8Array(res.data);
          var arr = new Array();
          for (var i = 0; i != data.length; ++i)
            arr[i] = String.fromCharCode(data[i]);
          var bstr = arr.join("");
          var workbook = XLSX.read(bstr, {
            type: "binary"
          });

          var first_sheet_name = workbook.SheetNames[0];
          var worksheet = workbook.Sheets[first_sheet_name];

          this.record = XLSX.utils.sheet_to_json(worksheet, {
            raw: true
          });
        })
        .catch(err => console.log(err));
    },
    createUrl(object, id) {
      return {
        customer: id,
        remit_type: object.remit_type,
        exchange_house: object.exchange_house,
        reference: object.reference,
        payment_date: new Date(object.payment_date).toISOString().slice(0, 10),
        sending_country: object.sending_country,
        sender: object.sender,
        amount: object.amount
      };
    },
    openModal() {
      this.$refs["check-record-modal"].show();
    },
    closeModal() {
      this.$refs["check-record-modal"].hide();
    }
  }
};
</script>