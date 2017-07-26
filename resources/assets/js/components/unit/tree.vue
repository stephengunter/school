<template>
<div v-if="loaded">
    <tree-view v-for="unit in units" 
          :model="unit" :key="unit.id"
          @selected="onSelected">
    </tree-view>
</div>

</template>

<script>
   
    export default {
        name: 'UnitTree',
        props:{
            version:{
              type:Number,
              default:0
            }

        },
        data() {
            return {
              
               loaded:false,
               units:[],
            }
        },
        watch: {
            version: function () {
                 this.init()
            },
        },
        beforeMount(){
           this.init()
        },
        methods: {
           init(){
            
              this.loaded=false
              this.units=[]
              this.fetchData()
              
           },
           fetchData() {
                let getData = Unit.tree()             
             
                getData.then(data => {
                   this.units=data.units
                   this.loaded = true                        
                })
                .catch(error=> {
                    Helper.BusEmitError(error)
                })
            },
            onSelected(id){
               this.$emit('selected',id)
            }
            
          
        }, 
    }
</script>
