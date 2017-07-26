<template>
<table v-if="loaded" class="table table-striped">
     <thead>
        <tr>
            <th v-for="item in thead" v-text="item.title" >
            </th>
        </tr>      
    </thead>
    <tbody>
        <tr v-for="unit in units">
            <td>
              <a href="#" @click.prevent="selected(unit.id)">{{ unit.name }}</a>
            </td>
            <td v-text="unit.code"></td>
            
            <td v-if="removed" v-html="$options.filters.removedLabel(unit.removed)" ></td>
            <td v-else v-html="$options.filters.activeLabel(unit.active)" ></td>
            
            <td v-if="!removed">
              <button @click="displayUp(unit.id)" class="btn btn-default btn-xs">
                <span class="glyphicon glyphicon-arrow-up" aria-hidden="true"></span>
              </button>
              <button @click="displayDown(unit.id)" class="btn btn-default btn-xs">
                <span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span>
              </button>
            </td>
            <td>
              <updated :entity="unit"></updated>
            </td>
        </tr>                  
    </tbody>
</table>

</template>

<script>
   
    export default {
        name: 'UnitList',
        props:{
            removed:{
              type:Boolean,
              default:false
            },
            parent:{
              type:Number,
              default:0
            },
            version:{
              type:Number,
              default:0
            }

        },
        data() {
            return {
               loaded:false,
               thead:[],
               units:[],
            }
        },
        watch: {
            version: function () {
                 this.fetchData()
            },
             parent: function () {
                 this.fetchData()
            },
        },
        beforeMount(){
           this.init()
        },
        methods: {
           init(){
              this.loaded=false
              this.units=[]
              this.thead=Unit.getThead()

              this.fetchData()
              
           },
           fetchData() {

                let getData = Unit.index(this.removed,this.parent)             
             
                getData.then(data => {
                   this.units=data.units
                   this.loaded = true                        
                })
                .catch(error=> {
                    Helper.BusEmitError(error)
                })
            },
            displayUp(id){
                this.updateDisplayOrder(id,true)
            },
            displayDown(id){
                this.updateDisplayOrder(id,false)
            },
            updateDisplayOrder(id,up){
                let update=Unit.updateDisplayOrder(id,up) 
              
                update.then(data => {
                   this.loaded=false
                   this.fetchData()                         
                })
                .catch(error => {
                    Helper.BusEmitError(error) 
                })
            },
            selected(id){
               this.$emit('selected',id)

            }
          
            
          
        }, 
    }
</script>
