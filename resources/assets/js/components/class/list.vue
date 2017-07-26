<template>
<table v-if="loaded" class="table table-striped">
     <thead>
        <tr>
            <th v-for="item in thead" v-text="item.title" >
            </th>
        </tr>      
    </thead>
    <tbody>
        <tr v-for="class in classs">
            <td>
              <a href="#" @click.prevent="selected(class.id)">{{ class.name }}</a>
            </td>
            <td v-text="class.code"></td>
            
            <td v-if="removed" v-html="$options.filters.removedLabel(class.removed)" ></td>
            <td v-else v-html="$options.filters.activeLabel(class.active)" ></td>
            
            <td v-if="!removed">
              <button @click="displayUp(class.id)" class="btn btn-default btn-xs">
                <span class="glyphicon glyphicon-arrow-up" aria-hidden="true"></span>
              </button>
              <button @click="displayDown(class.id)" class="btn btn-default btn-xs">
                <span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span>
              </button>
            </td>
            <td>
              <updated :entity="class"></updated>
            </td>
        </tr>                  
    </tbody>
</table>

</template>

<script>
   
    export default {
        name: 'ClassList',
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
               classs:[],
            }
        },
        watch: {
            version: function () {
                 this.fetchData()
            },
        },
        beforeMount(){
           this.init()
        },
        methods: {
           init(){
              this.loaded=false
              this.classs=[]
              this.thead=Class.getThead()

              this.fetchData()
              
           },
           fetchData() {

                let getData = Class.index(this.removed)             
             
                getData.then(data => {
                   this.classs=data.classs
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
                let update=Class.updateDisplayOrder(id,up) 
              
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
