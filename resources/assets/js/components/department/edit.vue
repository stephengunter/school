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
                            <label>名稱</label>
                            <input type="text" name="department.name" class="form-control" v-model="form.department.name"  >
                            <small class="text-danger" v-if="form.errors.has('department.name')" v-text="form.errors.get('department.name')"></small>
                        </div>
                    </div>
                    <div class="col-sm-3">
                         <div class="form-group">                           
                            <label>代碼</label>
                            <input type="text" name="department.code" class="form-control" v-model="form.department.code"  >
                            <small class="text-danger" v-if="form.errors.has('department.code')" v-text="form.errors.get('department.code')"></small>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">                           
                            <label>英文名稱</label>
                             <input type="text" name="department.en_name" class="form-control" v-model="form.department.en_name"  >
                            <small class="text-danger" v-if="form.errors.has('department.en_name')" v-text="form.errors.get('department.en_name')"></small>
                        </div>  
                    </div>
                    
                </div>
                <div class="row">
                    <div class="col-sm-3">
                         <div v-if="entityRemoved" class="form-group">                           
                            <label>已移除</label>
                            <div>
                               <input type="hidden" v-model="form.department.removed"  >
                               <toggle :items="removedOptions"   :default_val="form.department.removed" @selected=setRemoved></toggle>
                            </div>
                        </div>
                        <div v-else class="form-group">                           
                            <label>狀態</label>
                            <div>
                               <input type="hidden" v-model="form.department.active"  >
                               <toggle :items="activeOptions"   :default_val="form.department.active" @selected=setActive></toggle>
                            </div>
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
        name: 'EditDepartment',
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
                title:Helper.getIcon(Department.title()),
                loaded:false,
                form: new Form({
                    department: {
                      
                    }
                }),

                removedOptions: Helper.boolOptions(),
                activeOptions: Helper.activeOptions(),
            }
        },
        computed:{
            entityRemoved(){
                if(!this.form.department) return false
                return Helper.isTrue(this.form.department.removed)
            }
        },
        beforeMount() {
            this.init()
        },
        methods: {
            init() {
                this.loaded=false
                this.form = new Form({
                    department: {}
                    
                })
                if(this.id){
                    this.title += '  編輯科系'
                }else{
                    this.title += '  新增科系'
                }
                this.fetchData() 
            },
            fetchData() {
                let getData=null
                if(this.id){
                    getData=Department.edit(this.id)
                }else{
                    getData=Department.create()
                }
                getData.then(data=>{
                    let department=data.department
                    this.form.department=data.department

                    this.loaded=true
                }).catch(error=>{
                   Helper.BusEmitError(error)  
                   this.loaded=false
                })  
            },
          
            setActive(val){
                this.form.department.active=val
            },
            setRemoved(val){
                this.form.department.removed=val
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
                    store=Department.update(this.form , this.id)
                }else{
                    store=Department.store(this.form)
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
            onDepartmentSelected(item){
                this.selectedDepartment=item
            }




        },

    }
</script>