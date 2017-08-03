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
                <button v-if="staff.canEdit" v-show="can_edit" @click="btnEditCilcked" class="btn btn-primary btn-sm" >
                    <span class="glyphicon glyphicon-pencil"></span> 編輯
                 </button>
                 <button v-if="staff.canDelete" v-show="!hide_delete" @click="btnDeleteCilcked" class="btn btn-danger btn-sm" >
                    <span class="glyphicon glyphicon-trash"></span> 刪除
                 </button>
               
            </div>
        </div>  <!-- End panel-heading-->
        <div class="panel-body">
            <div class="row">
                 <div class="col-sm-3">
                      <label class="label-title">姓名</label>
                      <p v-text="staff.name"></p>                      
                 </div>
                 <div class="col-sm-3">
                      <label class="label-title">員工編號</label>
                      <p v-text="staff.number"></p>                      
                 </div>
                 <div class="col-sm-3">
                      <label class="label-title">部門</label>
                      <p v-text="staff.unit.name"></p>                      
                 </div>
                 <div class="col-sm-3">
                                         
                 </div>
            </div>   <!-- End row-->
            <div class="row">
                 <div class="col-sm-3">
                      <label class="label-title">到職日期</label>
                      <p v-text="staff.join_date"></p>                      
                 </div>
                 <div class="col-sm-3">
                      <label class="label-title">狀態</label>
                      <p v-if="isTrue(staff.removed)" v-html="$options.filters.removedLabel(staff.removed)"></p>   
                      <p v-else v-html="staffActiveLabel()"></p>     
                          
                 </div>
                 <div class="col-sm-3">
                      <label class="label-title">備註</label>
                      <p v-text="staff.ps"></p>                      
                 </div>
                 <div class="col-sm-3">
                      <label class="label-title">最後更新</label>
                      <updated :entity="staff"></updated>                    
                 </div>
            </div>   <!-- End row-->
       
        </div>  <!-- End panel-body-->

    </div>

    
 

</div>
</template>
<script>
    export default {
        name: 'ShowStaff', 
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
                title:Helper.getIcon('Staffs') + '  學生資料',
                loaded:false,
                staff:null,

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
                this.staff=null
                if(this.id) this.fetchData()
               
            },
            fetchData() {
                let getData=Staff.show(this.id)
               
                getData.then(data => {
                    this.staff = new Staff(data.staff)
                    
                    this.loaded = true 
                    this.$emit('loaded',this.staff)
                })
                .catch(error=> {
                    this.loaded = false 
                    Helper.BusEmitError(error)
                })
            }, 
            isTrue(val){
                return Helper.isTrue(val)
            },  
            staffActiveLabel(){
              
                let status=this.staff.status
                 return Staff.activeLabel(status)
            },
            btnEditCilcked(){
               this.$emit('begin-edit');
            },
            btnDeleteCilcked(){
                let values={
                  id:this.id,
                  name:this.staff.name
                }
                this.$emit('btn-delete-clicked',values)
              
            },
            onBtnBackClick(){
                this.$emit('btn-back-clicked')
            },

            

            
        }
    }
</script>