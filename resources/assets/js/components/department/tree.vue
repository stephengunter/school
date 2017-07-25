<template>
<div v-if="loaded">
    <tree-view v-for="department in departments" 
          :model="department" :key="department.id"
          @selected="onSelected">
    </tree-view>
</div>

</template>

<script>
   
    export default {
        name: 'DepartmentTree',
        props:{
            version:{
              type:Number,
              default:0
            }

        },
        data() {
            return {
              
               loaded:false,
               departments:[],
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
              this.departments=[]
              this.fetchData()
              
           },
           fetchData() {
                let getData = Department.tree()             
             
                getData.then(data => {
                   this.departments=data.departments
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
