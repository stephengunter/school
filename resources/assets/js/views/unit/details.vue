<template>
<div>
  <unit v-show="loaded" :id="id" :can_edit="can_edit" :can_back="can_back"  
     @saved="unitUpdated" @loaded="onDataLoaded" 
     @btn-back-clicked="onBtnBackClicked" @deleted="onUnitDeleted" > 

  </unit>
  
  
  
</div>
</template>

<script>
    import UnitComponent from '../../components/unit/unit.vue'
    
    export default {
        name: 'UnitDetails',
        components: {
            'unit':UnitComponent,
        },
        props: {
            id: {
              type: Number,
              default: 0
            },
            version: {
              type: Number,
              default: 0
            },
            can_edit:{
               type: Boolean,
               default: true
            },
            can_back:{
               type: Boolean,
               default: true
            },
        },
        data() {
            return {
               loaded:false,
               unit:null,
               current_version:0,

            }
        },
        
        beforeMount(){
           this.init()
        },
        methods: {
            init(){
              this.loaded=false
              this.readonly=true
              this.activeIndex=0
            },
            toBoolean(val){
               return val=='true'
            },
            onDataLoaded(unit){
                this.loaded=true
                this.unit=unit
            },
            btnEditClicked(){    
              this.beginEdit()
            },
            beginEdit(){
               this.readonly=false
            },
            editCanceled(){
               this.readonly=true
            },
            unitUpdated(){
               this.init()
            },
            onBtnBackClicked(){
                this.$emit('btn-back-clicked')
            },
            onUnitDeleted(){
               this.$emit('unit-deleted')
            },
            
        }, 

    }
</script>