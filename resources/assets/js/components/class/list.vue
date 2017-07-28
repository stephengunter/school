<template>
  <div v-if="loaded" class="panel panel-default show-data">
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
           <div class="form-inline">
                <div class="form-group">
                   <label class="ctr-label">年級</label>
                    <select  v-model="params.grade"   style="width:auto;" class="form-control selectWidth"
                      @change="onParamChanged">
                        <option v-for="item in gradeOptions" :value="item.value" v-text="item.text"></option>
                    </select>
                </div>
          </div>    
          <div>
              <button  @click="removed=true" class="btn btn-default btn-sm" >
                  <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                  資源回收桶
              </button>
              
              &nbsp;
              <button   @click="onBtnAddClicked" class="btn btn-primary btn-sm" >
                  <span class="glyphicon glyphicon-plus"></span> 新增
              </button>
          </div>
      </div>  <!-- End panel-heading-->
      <div v-if="loaded" class="panel-body">
          <table class="table table-striped">
               <thead>
                  <tr>
                      <th>年級</th>
                      <th>名稱</th>
                      <th>狀態</th>
                      <th v-if="!removed">順序</th>
                      <th>更新時間</th>
                      <th>&nbsp;</th>
                  </tr>      
              </thead>
              <tbody>
                   <row v-for="entity in entityList" key="entity.id"
                     :entity="entity" :removed="removed"
                     @saved="onClassUpdated" @btn-delete-clicked="beginDelete"
                     @order-up="displayUp" @order-down="displayDown">
                   </row>  
                   <row v-if="adding" :entity="newEntity" 
                     @canceled="onAddCanceled" 
                     @saved="onClassAdded"  >
                    
                   </row>         
              </tbody> 
          </table>

          <delete-confirm :showing="deleteConfirm.show" :message="deleteConfirm.msg"
            @close="closeConfirm" @confirmed="deleteEntity">        
          </delete-confirm>
       </div> <!-- End panel-body-->
  </div>
</template>

<script>
    import Row from './row.vue'
    export default {
        name: 'ClassList',
        components: {
            Row,
        },
        props:{
            
            department_id:{
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
               removed:false,

               params:{
                  department:0,
                  grade:0
               },
             
               entityList:[],

               adding:false,
               newEntity:{},

               deleteConfirm:{
                    id:0,
                    show:false,
                    msg:'',
                }  
            }
        },
        computed:{
            title(){

                 let text=Helper.getIcon(Classes.title())  + '  班級管理'
                 if(this.removed) text += ' (資源回收桶)'   
                    return text
            }, 
        },
        watch: {
            version: function () {
                 this.fetchData()
            },
            removed: function (val) {
                this.init()
            },
        },
        beforeMount(){
           this.init()
        },
        methods: {
           init(){
              this.loaded=false
              this.adding=false
              this.classList=[]
              this.params.department=this.department_id

              let options=Classes.indexOptions(this.department_id)
                options.then(data=>{
                    this.gradeOptions=data.gradeOptions
                    let allGrades={ text:'全部年級' , value:'0' }
                    this.gradeOptions.splice(0, 0, allGrades);
                    this.params.grade=this.gradeOptions[0].value
                    
                    this.fetchData()
                }).catch(error=>{
                    Helper.BusEmitError(error)
                    this.ready=false
                })

              
              
           },
           fetchData() {

                let getData =null          
                if(this.removed){
                    getData=Classes.trash()
                }else{
                   getData=Classes.index(this.params)
                }
                getData.then(data => {
                   this.entityList=data.classList
                   this.loaded = true                        
                })
                .catch(error=> {
                    Helper.BusEmitError(error)
                })
            },
            onParamChanged(){
                this.fetchData()
            },
            displayUp(id){
                this.updateDisplayOrder(id,true)
            },
            displayDown(id){
                this.updateDisplayOrder(id,false)
            },
            updateDisplayOrder(id,up){
                let update=Classes.updateDisplayOrder(id,up) 
              
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

            },
            onBtnAddClicked(){
                let getData=Classes.create(this.department_id)
                getData.then(data => {
                    let entity=data.entity
                    entity.grade_id=this.params.grade
                    this.newEntity = entity
                    this.adding=true
                    
                })
                .catch(error=> {
                    Helper.BusEmitError(error)
                })
                
            },
            onClassUpdated(){
              this.fetchData()
            },
            onClassAdded(){
              this.fetchData()
              this.adding=false
            },
            onAddCanceled(){
                this.adding=false
            },
            beginDelete(values){
                this.deleteConfirm.msg= '確定要刪除班級 『' + values.name + '』嗎' 
                this.deleteConfirm.id=values.id
                this.deleteConfirm.show=true                
            },
            closeConfirm(){
                this.deleteConfirm.show=false
            },
            deleteEntity(){
                let id = this.deleteConfirm.id 
                let remove= Classes.delete(id)
                remove.then(result => {
                    this.fetchData()
                    Helper.BusEmitOK('刪除成功')
                    this.deleteConfirm.show=false
                    
                })
                .catch(error => {
                    Helper.BusEmitError(error,'刪除失敗')
                    this.closeConfirm()   
                })
            },
          
            
          
        }, 
    }
</script>
