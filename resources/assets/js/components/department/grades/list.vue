<template>
  <div v-if="loaded" class="panel panel-default show-data">
      <div class="panel-heading">
          <span class="panel-title">
              <h4 v-html="title"></h4>
          </span>
          <div>
              <button  @click="beginEdit" class="btn btn-primary btn-sm" >
                  <span class="glyphicon glyphicon-pencil"></span> 編輯
              </button>
          </div>
      </div>  <!-- End panel-heading--> 
      
      <div v-if="loaded" class="panel-body">
          <table class="table table-striped">
              <tbody>
                   <tr>
                      <td>名稱</td>
                  </tr> 
              </tbody> 
          </table>
       </div> <!-- End panel-body-->
       
  </div>
</template>

<script>
    export default {
        name: 'DepartmentGrade',
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
             
               gradeList:[],

            }
        },
        computed:{
            title(){
                 return Helper.getIcon(Grade.title())  + '  年級管理'
            }, 
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
              this.adding=false
             

              this.fetchData()
              
           },
           fetchData() {
                this.grades=[]
                this.loaded = true  
                return
                let getData =null          
                
                getData.then(data => {
                   this.entityList=data.classList
                   this.loaded = true                        
                })
                .catch(error=> {
                    Helper.BusEmitError(error)
                })
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
            beginEdit(){
                this.$emit('begin-edit')
                // let getData=Classes.create(this.department_id)
                // getData.then(data => {
                //     this.newEntity = data.entity
                //     this.adding=true
                    
                // })
                // .catch(error=> {
                //     Helper.BusEmitError(error)
                // })
                
            },
            onAddCanceled(){
                this.adding=false
            },
            closeConfirm(){
                this.deleteConfirm.show=false
            },
            
            
          
        }, 
    }
</script>
