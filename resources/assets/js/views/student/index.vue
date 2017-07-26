<template>
<div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="form-inline">
                
                <div class="form-group">
                    <select  v-model="params.department"    style="width:auto;" class="form-control selectWidth">
                        <option v-for="item in departmentOptions" :value="item.value" v-text="item.text"></option>
                    </select>
                </div>
            </div>
        </div>
    </div>
     
    <student-list v-if="ready" :search_params="params"  :hide_create="hide_create" :version="version"  
        :can_select="can_select"
        @selected="onSelected" @begin-create="onBeginCreate">
    </student-list>

</div>

</template>

<script>
    import StudentList from '../../components/student/list.vue'
    

    export default {
        name: 'StudentIndex',       
        components: {
            'student-list':StudentList
        },
        props: {
            version: {
              type: Number,
              default: 0
            },
            hide_create:{
               type: Boolean,
               default: false
            }
        },
        data() {
            return {
                ready:false,
                departmentOptions:[],
                params:{
                    department:0,
                },
              
                can_select:false,
             
            }
        },
        beforeMount() {
             this.init()
        },
        methods: {
            init(){
                let options=Student.indexOptions()
                options.then(data=>{
                    this.departmentOptions=data.departmentOptions
                    let allDepartments={ text:'全部科系' , value:'0' }
                    this.departmentOptions.splice(0, 0, allCenters);
                    this.params.department=this.departmentOptions[0].value
                    
                    this.ready=true
                }).catch(error=>{
                    Helper.BusEmitError(error)
                    this.ready=false
                })
             
            },
            onSelected(id){
                this.$emit('selected',id)
            },
            onBeginCreate(){
                this.$emit('begin-create',this.student_id)
            }
            
            
        },

    }
</script>