<template>

    <div class="panel panel-default">
        
        <div class="panel-heading">    
             <span class="panel-title">
                  <h4 v-html="title"></h4>
             </span>           
        </div>
        <div  v-if="loaded"  class="panel-body">  
            <form class="form" @submit.prevent="onSubmit" @keydown="clearErrorMsg($event.target.name)">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">                           
                            <label>姓名</label>
                            <input type="text" name="staff.name" class="form-control" :value="form.staff.name"  disabled>
                        </div>
                    </div>
                    <div class="col-sm-3">
                         <div class="form-group">                           
                            <label>員工編號</label>
                            <input type="text" name="staff.number" class="form-control" :value="form.staff.number"  disabled>
                        </div>
                    </div>
                    <div class="col-sm-3">
                         <div class="form-group">                           
                            <label>部門</label>
                            <level-dropdown :default_item="selectedUnit" :options="unitOptions"
                                  @selected="onUnitSelected" >
                            </level-dropdown>
                            <!-- <input type="text" name="staff.department.name" class="form-control" :value="form.staff.department.name"  disabled> -->
                        </div>
                    </div>
                    <div class="col-sm-3">
                        
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                         <div class="form-group">                           
                            <label>到職日期</label>
                            <input type="text" name="staff.join_date" class="form-control" :value="form.staff.join_date"  disabled>
                        </div>
                    </div>
                    <div class="col-sm-3">
                         <div v-if="entityRemoved" class="form-group">                           
                            <label>已移除</label>
                            <div>
                               <input type="hidden" v-model="form.staff.removed"  >
                               <toggle :items="removedOptions"   :default_val="form.staff.removed" @selected=setRemoved></toggle>
                            </div>
                        </div>
                        <div v-else class="form-group">                           
                            <label>狀態</label>
                            <div>
                               <input type="hidden" v-model="form.staff.active"  >
                               <toggle :items="statusOptions"   :default_val="form.staff.status" @selected=setStatus></toggle>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                         <div class="form-group">                           
                            <label>備註</label>
                            <textarea rows="4" class="form-control" name="staff.ps"  v-model="form.staff.ps">
                            </textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                     <div class="col-sm-4">
                        <div class="form-group">                           
                            <button type="submit" class="btn btn-success" :disabled="form.errors.any()">確認送出</button>
                             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                             <button class="btn btn-default" @click.prevent="onCanceled">取消</button>  
                         </div>
                    </div>
                    
                </div><!-- </div> end row -->
                    
                
            </form>
           
        </div>
    </div>
    
</template>
<script>
    
    export default {
        name: 'EditStaff',
        props: {
            id: {
              type: Number,
              default: 0
            },
            course_id: {
              type: Number,
              default: 0
            },
        },
        data() {
            return {
                title:Helper.getIcon(Staff.title()),
                loaded:false,
                form: new Form({
                    staff: {
                      
                    }
                }),
                selectedUnit:{},
                removedOptions: Helper.boolOptions(),
                statusOptions: [],

                unitOptions:[],
            }
        },
        computed:{
            entityRemoved(){
                if(!this.form.staff) return false
                return Helper.isTrue(this.form.staff.removed)
            }
        },
        beforeMount() {
            this.init()
        },
        methods: {
            init() {
                this.loaded=false
                this.form = new Form({
                    staff: {}
                    
                })
                if(this.id){
                    this.title += '  編輯學生資料'
                }else{
                    this.title += '  新增學生資料'
                }
                this.fetchData() 
            },
            fetchData() {
                let getData=null
                if(this.id){
                    getData=Staff.edit(this.id)
                }else{
                    getData=Staff.create()
                }
                getData.then(data=>{
                    let staff=data.staff
                    this.form.staff=data.staff
                    this.statusOptions=data.statusOptions
                    this.unitOptions=data.unitOptions

                    this.selectedUnit={
                        value:staff.unit_id,
                        text:staff.unit.name
                    }

                    this.loaded=true
                }).catch(error=>{
                   Helper.BusEmitError(error)  
                   this.loaded=false
                })  
            },
            loadClassesOptions(){
                let options=Classes.options(this.form.staff.department_id)
                
                options.then(data=>{
                    this.classesOptions=data.options
                    this.form.staff.class_id=data.options[0].value
                }).catch(error=>{
                   Helper.BusEmitError(error)  
                }) 
            },          
            onUnitSelected(item){
                this.selectedUnit=item
                this.form.staff.unit_id=item.value
            },
            setStatus(val){
                this.form.staff.status=val
            },
            setRemoved(val){
                this.form.staff.removed=val
            },
            clearErrorMsg(name) {
                this.form.errors.clear(name)
            },
            onSubmit() {
                
                this.submitForm()
            },
            submitForm() {
                let store=null
                
                if(this.id){
                    store=Staff.update(this.form , this.id)
                }else{
                    store=Staff.store(this.form)
                }
               
                store.then(data => {
                   Helper.BusEmitOK()
                   this.$emit('saved',data)                            
                })
                .catch(error => {
                    Helper.BusEmitError(error) 
                })
            },
            onCanceled(){
                this.$emit('canceled')
            },
            onStaffSelected(item){
                this.selectedStaff=item
            }




        },

    }
</script>