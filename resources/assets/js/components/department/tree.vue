<template>
    <div v-if="loaded" class="panel panel-default show-data">
      <div class="panel-heading">
          <span class="panel-title">
              <h4 v-html="title"></h4>
          </span>    
          <div>
              <!-- <button  v-if="category.canEdit" v-show="can_edit" @click="btnEditClicked" class="btn btn-primary btn-sm" >
                  <span class="glyphicon glyphicon-pencil"></span> 編輯
              </button> -->
          </div>
      </div>  <!-- End panel-heading--> 
      <div v-if="loaded" class="panel-body">
          
          <tree-view v-for="department in departments" 
          :model="department" :key="department.id">
            
          </tree-view>
            
           
       
      </div><!-- End panel-body-->


    </div>  
  


  


</template>

<script>
   
    export default {
        name: 'DepartmentTree',
        data() {
            return {
               title:Helper.getIcon(Department.title())  + '  部門管理',
               loaded:false,
               departments:[],
            }
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
            btnEditClicked(){   
              this.$emit('begin-edit') 
            },
            onBtnBackClick(){
                this.$emit('btn-back-clicked')
            },
            
          
        }, 
    }
</script>
