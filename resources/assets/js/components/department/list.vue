<template>
<table v-if="loaded" class="table table-striped">
     <thead>
        <tr>
            <th v-for="item in thead" v-text="item.title" >
            </th>
        </tr>      
    </thead>
    <tbody>
        <tr v-for="department in departments">
            <td>
              <a href="#" @click.prevent="selected(department.id)">{{ department.name }}</a>
            </td>
            <td v-text="department.code"></td>
            
            <td v-if="removed" v-html="$options.filters.removedLabel(department.removed)" ></td>
            <td v-else v-html="$options.filters.activeLabel(department.active)" ></td>
            
            <td v-if="!removed">
              <button @click="displayUp(department.id)" class="btn btn-default btn-xs">
                <span class="glyphicon glyphicon-arrow-up" aria-hidden="true"></span>
              </button>
              <button @click="displayDown(department.id)" class="btn btn-default btn-xs">
                <span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span>
              </button>
            </td>
            <td>
              <updated :entity="department"></updated>
            </td>
        </tr>                  
    </tbody>
</table>

</template>

<script>
   
    export default {
        name: 'DepartmentList',
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
               departments:[],
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
              this.departments=[]
              this.thead=Department.getThead()

              this.fetchData()
              
           },
           fetchData() {

                let getData = Department.index(this.removed,this.parent)             
             
                getData.then(data => {
                   this.departments=data.departments
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
                let update=Department.updateDisplayOrder(id,up) 
              
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
