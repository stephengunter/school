<template>

    <div class="panel panel-default">
        <div  v-if="loaded"  class="panel-body">  
            <form class="form" @submit.prevent="onSubmit" @keydown="clearErrorMsg($event.target.name)">
                <div class="row">
                    <div v-for="option in gradeOptions" class="col-sm-3">
                        <checkbox-label :option="option"
                         @selected="gradeSelected" @unselected="gradeUnSelected">
                            
                        </checkbox-label>
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
                form: {},
                gradeOptions:[],
                selectedIds:[],
            }
        },
        computed:{
            loaded(){
                return this.gradeOptions.length > 0
            }
        },
        beforeMount() {
            this.init()
        },
        methods: {
            init() {
                this.gradeOptions=[]
                this.form = new Form({
                    department:this.department_id,
                    grades:''
                    
                })
               
                this.fetchData() 
            },
            fetchData() {
              
                let getData=DepartmentGrades.edit(this.department_id)
                getData.then(data=>{
                    this.gradeOptions=data.gradeOptions
                }).catch(error=>{
                   Helper.BusEmitError(error)  
                   this.loaded=false
                })  
            },
            gradeSelected(option){
                let id=option.value
                let i = this.selectedIds.indexOf(id);
                if( i < 0){
                    this.selectedIds.push(id)
                }
            },
            gradeUnSelected(option){
                let id=option.value
                let i = this.selectedIds.indexOf(id);
                if( i >= 0){
                    this.selectedIds.splice(i, 1);
                }
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