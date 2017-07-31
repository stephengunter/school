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
                <button v-if="student.canEdit" v-show="can_edit" @click="btnEditCilcked" class="btn btn-primary btn-sm" >
                    <span class="glyphicon glyphicon-pencil"></span> 編輯
                 </button>
                 <button v-if="student.canDelete" v-show="!hide_delete" @click="btnDeleteCilcked" class="btn btn-danger btn-sm" >
                    <span class="glyphicon glyphicon-trash"></span> 刪除
                 </button>
               
            </div>
        </div>  <!-- End panel-heading-->
        <div class="panel-body">
            <div class="row">
                 <div class="col-sm-3">
                      <label class="label-title">姓名</label>
                      <p v-text="student.name"></p>                      
                 </div>
                 <div class="col-sm-3">
                      <label class="label-title">學號</label>
                      <p v-text="student.number"></p>                      
                 </div>
                 <div class="col-sm-3">
                      <label class="label-title">科系</label>
                      <p v-text="student.department.name"></p>                      
                 </div>
                 <div class="col-sm-3">
                      <label class="label-title">班級</label>
                      <p v-text="student.class.name"></p>                      
                 </div>
            </div>   <!-- End row-->
            <div class="row">
                 <div class="col-sm-3">
                      <label class="label-title">入學日期</label>
                      <p v-text="student.join_date"></p>                      
                 </div>
                 <div class="col-sm-3">
                      <label class="label-title">狀態</label>
                      <p v-if="isTrue(student.removed)" v-html="$options.filters.removedLabel(student.removed)"></p>   
                      <p v-else v-html="studentActiveLabel()"></p>     
                          
                 </div>
                 <div class="col-sm-3">
                      <label class="label-title">備註</label>
                      <p v-text="student.ps"></p>                      
                 </div>
                 <div class="col-sm-3">
                      <label class="label-title">最後更新</label>
                      <updated :entity="student"></updated>                    
                 </div>
            </div>   <!-- End row-->
       
        </div>  <!-- End panel-body-->

    </div>

    
 

</div>
</template>
<script>
    export default {
        name: 'ShowStudent', 
        props: {
            id: {
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
            hide_delete:{
              type: Boolean,
              default: false
            },
            version: {
              type: Number,
              default: 0
            },
        },
        data() {
             return {
                title:Helper.getIcon('Students') + '  學生資料',
                loaded:false,
                student:null,

            }
        },
        watch: {
            'version':'init'
        },
        beforeMount() {
            this.init()
        },  
        methods: {    
            init(){
                this.loaded=false
                this.student=null
                if(this.id) this.fetchData()
               
            },
            fetchData() {
                let getData=Student.show(this.id)
               
                getData.then(data => {
                    this.student = new Student(data.student)
                    
                    this.loaded = true 
                    this.$emit('loaded',this.student)
                })
                .catch(error=> {
                    this.loaded = false 
                    Helper.BusEmitError(error)
                })
            }, 
            isTrue(val){
                return Helper.isTrue(val)
            },  
            studentActiveLabel(){
                let active=this.student.active
                 return Student.activeLabel(active)
            },
            btnEditCilcked(){
               this.$emit('begin-edit');
            },
            btnDeleteCilcked(){
                let values={
                  id:this.id,
                  name:this.student.name
                }
                this.$emit('btn-delete-clicked',values)
              
            },
            onBtnBackClick(){
                this.$emit('btn-back-clicked')
            },

            

            
        }
    }
</script>