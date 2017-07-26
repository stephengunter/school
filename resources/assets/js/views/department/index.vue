<template>
   
   <div  class="panel panel-default show-data">
      <div v-if="removed" class="panel-heading">
          <span class="panel-title">
              <h4 v-html="title"></h4>
          </span>
            
          <div>
              <button @click="removed=false" class="btn btn-default btn-sm" >
                     <span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span>
                     返回
              </button>

          </div>
      </div>  <!-- End panel-heading--> 
      <div v-else class="panel-heading">
          <span class="panel-title">
              <h4 v-html="title"></h4>
          </span>    
           
          <div>
              <button  @click="removed=true" class="btn btn-default btn-sm" >
                  <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                  資源回收桶
              </button>
              
              &nbsp;
              <button  @click="btnAddClicked" class="btn btn-primary btn-sm" >
                  <span class="glyphicon glyphicon-plus"></span> 新增
              </button>

          </div>
      </div>  <!-- End panel-heading--> 
      <div class="panel-body">
          
            
         
             <department-list   :version="listSettings.version" 
              :removed="removed" 
              @selected="onSelected">
             </department-list>
        
          
           
       
      </div><!-- End panel-body-->


    </div> 
</template>

<script>
    
    import DepartmentList from '../../components/department/list.vue'
    export default {
        name:'DepartmentIndexView',
        components: {
            'department-list':DepartmentList
        },
        props:{
            version:{
              type:Number,
              default:0
            }
        },
        data() {
            return {
               removed:false,
              
               listSettings:{
                  version:0
               },


            }
        },
        watch: {
            version:function(){
               this.listSettings.version+=1
            },
            removed: function (val) {
               this.listSettings.version+=1
            },
        },
        computed:{
            title(){
                 let text=Helper.getIcon(Department.title())  + '  科系管理'
                 if(this.removed) text += ' (資源回收桶)'   
                    return text
            }, 
        },
        beforeMount(){
           this.init()
        },
        methods: {
            init(){
                
            },
            onDepartmentSelected(item){
                this.selectedDepartment=item
            },
            btnAddClicked(){
                this.$emit('begin-create')
            },
            
            onSelected(id){
                this.$emit('selected',id)
            }
        }
    }
</script>