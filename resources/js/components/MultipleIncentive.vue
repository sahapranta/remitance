<template>
    <div>
        <b-table            
            hover
            :items="items"
            selectable
            @row-selected="onRowSelected"
            responsive="sm"
        ></b-table>
        <b-button variant="dark">Back</b-button>
        <b-button variant="success" @click="submit">Submit</b-button>
    </div>
</template>

<script>
    export default {
        props: ["remitances", "customer"],
        data() {
            return {
                selected_row: [],
                fields: ["id", "reference", "amount", "payment_date"]
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
                    u.incentive_amount = this.calc(item.amount * 0.02);
                    return u;
                });
            },
            onRowSelected(item) {
                this.selected_row = item.map(it=>{
                    return {
                        id:it.id,                        
                        incentive_date: new Date(),
                        incentive_amount: this.calc(it.amount * 0.02)
                    };
                });
            },
            submit() {
                axios
                    .post(`/remitance/${this.customer}/payall`, {
                        data: this.selected_row
                    })
                    .then(res=>{
                        if (res.status === 200) {                            
                            this.$bvToast.toast('Toast body content', {
                                title: `Data submitted Successfully`,
                                variant: 'warning',
                                solid: true
                            });
                            setTimeout(() => {
                                window.location.href = `/customer/${this.customer}`;
                            }, 2000);
                        }
                    })
                    .catch(err=>console.log(err));
            }
        },
        computed: {
            items() {
                return this.pluck(this.remitances, this.fields);
            },            
        }
    };
</script>
