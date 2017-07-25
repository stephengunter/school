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
                let getData = Department.index(this.removed)             
             
                getData.then(data => {
                   this.departments=data.departments
                   this.loaded = true                        
                })
                .catch(error=> {
                    Helper.BusEmitError(error)
                })
            },
            selected(id){
               this.$emit('selected',id)
            }
          
            
          
        }, 
    }
</script>
