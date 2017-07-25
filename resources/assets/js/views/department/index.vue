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
              <button  @click="changeMode" class="btn btn-warning btn-sm" >
                  <span v-if="treeMode"  class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                  <i v-else class="fa fa-sitemap" aria-hidden="true"></i>

                  {{ changeModeText  }}
              </button>
              &nbsp;
              <button  @click="btnAddClicked" class="btn btn-primary btn-sm" >
                  <span class="glyphicon glyphicon-plus"></span> 新增
              </button>

          </div>
      </div>  <!-- End panel-heading--> 
      <div class="panel-body">
          
          <department-tree v-if="treeMode" :version="treeSettings.version" 
           @selected="onSelected"></department-tree>

          <department-list v-else  :version="listSettings.version" 
          :removed="removed" @selected="onSelected">
          </department-list>
           
       
      </div><!-- End panel-body-->


    </div> 
</template>

<script>
    import DepartmentTree from '../../components/department/tree.vue'
    import DepartmentList from '../../components/department/list.vue'
    export default {
        name:'DepartmentIndexView',
        components: {
            'department-tree':DepartmentTree,
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
               treeMode:true,
               listSettings:{
                  version:0
               },
               treeSettings:{
                  version:0
               },

            }
        },
        watch: {
            version:function(){
               this.listSettings.version+=1
               this.treeSettings.version+=1
            },
            removed: function (val) {
               if(val){
                  this.treeMode=false
               }

               this.listSettings.version+=1
            },
        },
        computed:{
            title(){
                 let text=Helper.getIcon(Department.title())  + '  部門管理'
                 if(this.removed) text += ' (資源回收桶)'   
                    return text
            },
            changeModeText(){
                if(this.treeMode) return '列表模式'
                else return '樹狀模式'
            }    
        },
        methods: {
            btnAddClicked(){
                this.$emit('create')
            },
            changeMode(){
                this.treeMode=!this.treeMode
            },
            onSelected(id){
                this.$emit('selected',id)
            }
        }
    }
</script>