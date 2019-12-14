<template>
    <div class="row">
        <div class="col-6">
            <div class="form-group">
                <select name="remit_type" class="form-control" v-model="selected_remit">
                    <option value="">Select Remitance Type</option>
                    <option v-for="(type, i ) in remit_type" :value="type" :key="i">{{type}}</option>
                </select>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <select name="exchange_house" class="form-control" v-model="selected_house">
                    <option value="">Select Exchange House</option>
                    <option v-for="(htype,i ) in houseType" :value="htype" :key="i">{{htype}}</option>
                </select>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props:['spotcash', 'coc', 'predata'],
        data(){
            return {
                remit_type: ['SpotCash', 'COC', 'QRemit', 'Online'],
                house_type: '',                
                selected_remit: '',
                selected_house: '',
            }
        },        
        computed:{
            houseType:function(){                
                return this.house_type[this.selected_remit.toLowerCase()] || [];
            }
        },
        mounted() {
            this.house_type = {
                    'spotcash' : this.spotcash,
                    'coc' : this.coc,
                    'qremit' : ['qremit'],
                    'online' : ['online'],
                };
            if (this.predata.length === 2) {
                this.selected_remit = this.predata[0];
                this.selected_house = this.predata[1];
            }
        }
    }
</script>