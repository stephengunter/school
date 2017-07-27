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
              
              <button  class="btn btn-default btn-sm" @click.prevent="onRefresh">
                     <span  class="glyphicon glyphicon-refresh" aria-hidden="true"></span>
             </button>
             
              <button  @click="beginCreate" class="btn btn-primary btn-sm" >
                  <span class="glyphicon glyphicon-plus"></span> 新增
              </button>

          </div>
      </div>  <!-- End panel-heading--> 
      <div class="panel-body">
          
          <grade-list   :version="listSettings.version" 
               :creating="listSettings.creating"  :removed="removed" 
              @selected="onSelected" @create-canceled="onCreateCanceled"
              @grade-created="onGradeCreated">
          </grade-list>
         
            
        
          
           
       
      </div><!-- End panel-body-->


    </div> 
</template>

<script>
    import GradeList from '../../components/grade/list.vue'
    export default {
        name:'GradeIndexView',
        components: {
            'grade-list':GradeList
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
                  version:0,
                  creating:false
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
                 let text=Helper.getIcon(Grade.title())  + '  年級管理'
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
            onGradeSelected(item){
                this.selectedGrade=item
            },
            beginCreate(){
                this.listSettings.creating=true
            },
            onCreateCanceled(){
                this.listSettings.creating=false
            },
            onGradeCreated(){
               this.listSettings.creating=false
            },
            onRefresh(){
               this.listSettings.version+=1
            },
            onSelected(id){
                this.$emit('selected',Number(id))
            }
        }
    }
</script>