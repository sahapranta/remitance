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
        data(){
            return {
                remit_type: ['SpotCash', 'COC', 'QRemit', 'Online'],
                house_type: {
                    'spotcash' : ["AGEX", "AMX", "ARH Canada", "BRAC", "CASH EXPRESS", "CITY PAY", "EzRemit", "FSIE", "GME", "GULF OVERSEAS", "HelloPaisa", "IME", "INFINITY", "INSTANT CASH", "K & H", "KBE", "MAX", "MEC", "MECB", "MERCHANTRADE", "MONEYGRAM", "NBL", "NBL GREECE", "NBL USA", "NEC", "NEC UK", "PLACID", "PRABHU", "REMITONE", "RIA", "TRANSFAST", "TURBO CASH", "UREMIT", "WESTERN UNION", "XPRESSMONEY"],
                    'coc' : [ "7009", "7010203", "7010204", "7010205", "7010206", "7010207", "7010208", "7010209", "7010211", "7010213", "7010215", "7010216", "7010219", "7010220", "7010221", "7010223", "7010224", "7010225", "7010229", "7010230", "7010231", "7010232", "7010233", "7010234", "7010235", "7010236", "7010237", "7010238", "7010239", "7010240", "7010241", "7010242", "7010243", "7010244", "7010245", "7010246", "7010247", "7010248", "7010249", "7010250", "7010251", "7010252", "7010253", "7010254", "7010255", "7010256", "7010257", "7010258", "7010259", "7010260", "7010261", "7010262", "7010263", "7010264", "7010265", "7010266", "7010268", "7010268", "7010270", "7010274", "7010283"],
                    'qremit' : ['qremit'],
                    'online' : ['online'],
                },                
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

        }
    }
</script>