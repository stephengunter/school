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
                            <input type="text" name="student.name" class="form-control" :value="form.student.name"  disabled>
                        </div>
                    </div>
                    <div class="col-sm-3">
                         <div class="form-group">                           
                            <label>學號</label>
                            <input type="text" name="student.number" class="form-control" :value="form.student.number"  disabled>
                        </div>
                    </div>
                    <div class="col-sm-3">
                         <div class="form-group">                           
                            <label>科系</label>
                            <select  v-model="form.student.department_id"   class="form-control">
                                 <option v-for="item in departmentOptions" :value="item.value" v-text="item.text"></option>
                            </select>
                            <!-- <input type="text" name="student.department.name" class="form-control" :value="form.student.department.name"  disabled> -->
                        </div>
                    </div>
                    <div class="col-sm-3">
                         <div class="form-group">                           
                            <label>班級</label>
                            <input type="text" name="student.class.name" class="form-control" :value="form.student.class.name"  disabled>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                         <div class="form-group">                           
                            <label>入學日期</label>
                            <input type="text" name="student.join_date" class="form-control" :value="form.student.join_date"  disabled>
                        </div>
                    </div>
                    <div class="col-sm-3">
                         <div v-if="entityRemoved" class="form-group">                           
                            <label>已移除</label>
                            <div>
                               <input type="hidden" v-model="form.student.removed"  >
                               <toggle :items="removedOptions"   :default_val="form.student.removed" @selected=setRemoved></toggle>
                            </div>
                        </div>
                        <div v-else class="form-group">                           
                            <label>狀態</label>
                            <div>
                               <input type="hidden" v-model="form.student.active"  >
                               <toggle :items="activeOptions"   :default_val="form.student.active" @selected=setActive></toggle>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                         <div class="form-group">                           
                            <label>備註</label>
                            <textarea rows="4" class="form-control" name="student.ps"  v-model="form.student.ps">
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
        name: 'EditStudent',
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
                title:Helper.getIcon(Student.title()),
                loaded:false,
                form: new Form({
                    student: {
                      
                    }
                }),

                removedOptions: Helper.boolOptions(),
                activeOptions: Helper.activeOptions(),

                departmentOptions:[],
            }
        },
        computed:{
            entityRemoved(){
                if(!this.form.student) return false
                return Helper.isTrue(this.form.student.removed)
            }
        },
        beforeMount() {
            this.init()
        },
        methods: {
            init() {
                this.loaded=false
                this.form = new Form({
                    student: {}
                    
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
                    getData=Student.edit(this.id)
                }else{
                    getData=Student.create()
                }
                getData.then(data=>{
                    let student=data.student
                    this.form.student=data.student
                    this.departmentOptions=data.departmentOptions

                    this.loaded=true
                }).catch(error=>{
                   Helper.BusEmitError(error)  
                   this.loaded=false
                })  
            },
          
            setActive(val){
                this.form.student.active=val
            },
            setRemoved(val){
                this.form.student.removed=val
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
                    store=Student.update(this.form , this.id)
                }else{
                    store=Student.store(this.form)
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
            onStudentSelected(item){
                this.selectedStudent=item
            }




        },

    }
</script>