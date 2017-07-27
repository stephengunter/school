<template>

    <div class="panel panel-default">
        <div  v-if="loaded"  class="panel-body">  
            <form class="form" @submit.prevent="onSubmit" @keydown="clearErrorMsg($event.target.name)">
                <div class="row">
                    <div class="col-sm-3">
                        <checkbox-list></checkbox-list>
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
        name: 'EditDepartmentGrades',
        props: {
            department_id: {
              type: Number,
              default: 0
            },
        },
        data() {
            return {
                loaded:false,
                form: new Form({
                    department:this.department_id,
                    grades:''
                }),
            }
        },
        computed:{
            
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
               
                this.fetchData() 
            },
            fetchData() {
                 this.loaded=true
                return false
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