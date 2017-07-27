<template>
<div>
  <table class="table table-striped">
       <thead>
          <tr>
              <th>名稱</th>
              <th v-if="removed">狀態</th>
              <th v-if="!removed">順序</th>
              <th>更新時間</th>
              <th>&nbsp;</th>
          </tr>      
      </thead>
      <tbody>
           <row v-for="grade in gradeList" key="grade.id"
             :grade="grade" :removed="removed"
             @saved="init" @btn-delete-clicked="beginDelete"
             @order-up="displayUp" @order-down="displayDown">
           </row>  
           <row v-if="createReady" :grade="newEntity" 
             @canceled="onCreateCanceled" 
             @saved="onGradeCreated"  >
            
           </row>         
      </tbody> 
    </table>
    <delete-confirm :showing="deleteConfirm.show" :message="deleteConfirm.msg"
         @close="closeConfirm" @confirmed="deleteGrade">        
    </delete-confirm>
</div>    
</template>

<script>
    import Row from './row.vue'
    export default {
        name: 'GradeList',
        components: {
            Row,
        },
        props:{
            creating:{
              type:Boolean,
              default:false
            },
            removed:{
              type:Boolean,
              default:false
            },
            version:{
              type:Number,
              default:0
            }

        },
        data() {
            return {
               loaded:false,
             
               gradeList:[],

               createReady:false,
               newEntity:{},

               deleteConfirm:{
                    id:0,
                    show:false,
                    msg:'',
                }  
            }
        },
        watch: {
            version: function () {
                 this.fetchData()
            },
            creating: function (val) {
                if(val){
                   this.beginCreate()
                }else{
                   this.createReady=false
                } 
            },
        },
        beforeMount(){
           this.init()
        },
        methods: {
           init(){
              this.loaded=false
              this.createReady=false

              this.fetchData()

              if(this.creating) {
                this.beginCreate()
              }

              
           },
           fetchData() {

                this.classList=[]
                let getData =null          
                if(this.removed){
                    getData=Grade.trash()
                }else{
                   getData=Grade.index()
                }
                getData.then(data => {
                   this.gradeList=data.gradeList
                   this.loaded = true                        
                })
                .catch(error=> {
                    Helper.BusEmitError(error)
                })
            },
            displayUp(id){
                this.updateDisplayOrder(id,true)
            },
            displayDown(id){
                this.updateDisplayOrder(id,false)
            },
            updateDisplayOrder(id,up){
                let update=Grade.updateDisplayOrder(id,up) 
              
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
            beginCreate(){
                let getData=Grade.create()
                getData.then(data => {
                    this.newEntity = data.grade
                    this.createReady=true
                })
                .catch(error=> {
                    Helper.BusEmitError(error)
                })
                
            },
            onCreateCanceled(){
                this.$emit('create-canceled')
            },
            onGradeCreated(){
                 this.fetchData()
                 this.$emit('grade-created')
            },
            beginDelete(values){

                this.deleteConfirm.msg= '確定要刪除年級 『' + values.name + '』嗎' 
                this.deleteConfirm.id=values.id
                this.deleteConfirm.show=true                
            },
            closeConfirm(){
                this.deleteConfirm.show=false
            },
            deleteGrade(){
                let id = this.deleteConfirm.id 
                let remove= Grade.delete(id)
                remove.then(result => {
                    this.init()
                    Helper.BusEmitOK('刪除成功')
                    this.deleteConfirm.show=false
                    this.$emit('deleted')
                })
                .catch(error => {
                    Helper.BusEmitError(error,'刪除失敗')
                    this.closeConfirm()   
                })
            },
          
            
          
        }, 
    }
</script>
