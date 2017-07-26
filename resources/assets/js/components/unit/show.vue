<template>
    <div v-if="loaded" class="panel panel-default show-data">
      <div class="panel-heading">
          <span class="panel-title">
              <h4 v-html="title"></h4>
          </span>    
          <div>
              <button v-show="can_back"  @click="onBtnBackClick" class="btn btn-default btn-sm" >
                 <span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span>
                 返回
              </button>
              <button  v-if="unit.canEdit" v-show="can_edit" @click="btnEditClicked" class="btn btn-primary btn-sm" >
                  <span class="glyphicon glyphicon-pencil"></span> 編輯
              </button>
              <button v-if="unit.canDelete" v-show="can_edit" @click="btnDeleteClicked" class="btn btn-danger btn-sm" >
                  <span class="glyphicon glyphicon-trash"></span> 刪除
              </button>
          </div>
      </div>  <!-- End panel-heading--> 
      <div v-if="loaded" class="panel-body">
       
            <div class="row">
                 <div class="col-sm-3">
                      <label class="label-title">名稱</label>
                      <p v-text="unit.name"></p>                      
                 </div>
                 <div class="col-sm-2">
                      <label class="label-title">代碼</label>
                      <p v-html="unit.code">                       
                      </p>
                  </div>
                 <div class="col-sm-3">
                      <label class="label-title">母部門</label>
                     
                      <p v-text="unit.parent">                       
                      </p>                     
                 </div>
                  <div v-if="entityRemoved" class="col-sm-2" >
                      <label class="label-title">狀態</label>
                      <p v-html="$options.filters.removedLabel(unit.removed)">                       
                      </p>
                  </div>
                  <div v-else class="col-sm-2">
                      <label class="label-title">狀態</label>
                      <p v-html="$options.filters.activeLabel(unit.active)">                       
                      </p>
                  </div>
                  <div class="col-sm-2">
                      <label class="label-title">最後更新</label>
                      <updated :entity="unit"></updated>
                  </div>
            </div>   <!-- End row-->
            
           
       
      </div><!-- End panel-body-->


    </div>  
  


  


</template>

<script>
   
    export default {
        name: 'ShowUnit',
        props: {
            id: {
              type: Number,
              default: 0
            },
            version: {
              type: Number,
              default: 0
            },
            can_edit:{
               type: Boolean,
               default: true
            },
            can_back:{
               type: Boolean,
               default: true
            },
        },
        data() {
            return {
               title:Helper.getIcon(Unit.title())  + '  部門管理',
               loaded:false,
               unit:null,
            }
        },
        computed:{
            entityRemoved(){
             
                return Helper.isTrue(this.unit.removed)
            }
        },
        watch:{
          'version' : 'init'
        },
        beforeMount(){
           this.init()
        },
        methods: {
           init(){
            
              this.loaded=false
              this.unit=null
              if(this.id) this.fetchData()
              
           },
           fetchData() {
                let getData = Unit.show(this.id)             
             
                getData.then(data => {
                   let unit= data.unit
                   this.unit=new Unit(unit)
                   this.$emit('loaded',unit)
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
            btnDeleteClicked(){
                 let values={
                    name: this.unit.name,
                    id:this.id
                }
               this.$emit('btn-delete-clicked',values)
            
            },
          
        }, 
    }
</script>
