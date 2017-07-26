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
          <div v-if="loaded">
            <label class="ctr-label">母部門 </label>
             <div class="inline-ctr" >
               <level-dropdown :default_item="selectedUnit" :options="unitOptions"
                     @selected="onUnitSelected" >
               </level-dropdown>
             </div>
          </div>  
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
          <div v-if="treeMode">
            <unit-tree :version="treeSettings.version" 
             @selected="onSelected"></unit-tree>
          </div>
          <div v-else>
             <unit-list  v-if="loaded" :version="listSettings.version" 
              :removed="removed" :parent="selectedUnit.value"
              @selected="onSelected">
             </unit-list>
          </div>
          
           
       
      </div><!-- End panel-body-->


    </div> 
</template>

<script>
    import UnitTree from '../../components/unit/tree.vue'
    import UnitList from '../../components/unit/list.vue'
    export default {
        name:'UnitIndexView',
        components: {
            'unit-tree':UnitTree,
            'unit-list':UnitList
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

               loaded:false,
               unitOptions:[],
               selectedUnit:{},


            }
        },
        watch: {
            treeMode:function(){
               this.init()
            },
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
                 let text=Helper.getIcon(Unit.title())  + '  部門管理'
                 if(this.removed) text += ' (資源回收桶)'   
                    return text
            },
            changeModeText(){
                if(this.treeMode) return '列表模式'
                else return '樹狀模式'
            }    
        },
        beforeMount(){
           this.init()
        },
        methods: {
            init(){
                this.loaded=false
                if(this.treeMode){

                }else{

                    let options=Unit.options()
                    options.then(data=>{
                        this.unitOptions=data.options
                        let rootOption=Unit.rootOption()
                        this.unitOptions.splice(0, 0, rootOption)
                        this.selectedUnit=rootOption

                        this.loaded=true
                    }).catch(error =>{
                        Helper.BusEmitError(error)
                    })
                }
            },
             onUnitSelected(item){
                this.selectedUnit=item
            },
            btnAddClicked(){
                this.$emit('begin-create')
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