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
              <button  v-if="department.canEdit" v-show="can_edit" @click="btnEditClicked" class="btn btn-primary btn-sm" >
                  <span class="glyphicon glyphicon-pencil"></span> 編輯
              </button>
              <button v-if="department.canDelete" v-show="can_edit" @click="btnDeleteClicked" class="btn btn-danger btn-sm" >
                  <span class="glyphicon glyphicon-trash"></span> 刪除
              </button>
          </div>
      </div>  <!-- End panel-heading--> 
      <div v-if="loaded" class="panel-body">
       
            <div class="row">
                 <div class="col-sm-3">
                      <label class="label-title">名稱</label>
                      <p v-text="department.name"></p>                      
                 </div>
                 <div class="col-sm-2">
                      <label class="label-title">代碼</label>
                      <p v-html="department.code">                       
                      </p>
                  </div>
                 <div class="col-sm-3">
                      <label class="label-title">母部門</label>
                     
                      <p v-html="$options.filters.parents(department.icon)">                       
                      </p>                     
                 </div>
                  <div class="col-sm-2">
                      <label class="label-title">狀態</label>
                      <p v-html="$options.filters.activeLabel(department.active)">                       
                      </p>
                  </div>
                  <div class="col-sm-2">
                      <label class="label-title">最後更新</label>
                      <updated :entity="department"></updated>
                  </div>
            </div>   <!-- End row-->
            
           
       
      </div><!-- End panel-body-->


    </div>  
  


  


</template>

<script>
   
    export default {
        name: 'ShowDepartment',
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
               title:Helper.getIcon(Department.title())  + '  部門管理',
               loaded:false,
               department:null,
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
              this.department=null
              if(this.id) this.fetchData()
              
           },
           fetchData() {
                let getData = Department.show(this.id)             
             
                getData.then(data => {
                   let department= data.department
                   this.department=new Department(department)
                   this.$emit('loaded',department)
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
                    name: this.department.name,
                    id:this.id
                }
               this.$emit('btn-delete-clicked',values)
            
            },
          
        }, 
    }
</script>
