<template>
<div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <combination-select v-show="!removed"
            :with_classes="optionsSettings.with_classes" :empty_classes="optionsSettings.empty_classes"
            :empty_department="optionsSettings.empty_department" :empty_grade="optionsSettings.empty_grade"
             @ready="onOptionsReady"  >
                
            </combination-select>
            <div v-if="removed">
                <button @click="removed=false" class="btn btn-default btn-sm" >
                     <span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span>
                     返回
                </button>

            </div>
            <div v-else>
              <button  @click="removed=true" class="btn btn-default btn-sm" >
                  <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                  資源回收桶
              </button>
              &nbsp;
              
              <button  @click="onBtnAddClicked" class="btn btn-primary btn-sm" >
                  <span class="glyphicon glyphicon-plus"></span> 新增
              </button>

          </div>
        </div>
        
    </div>
     
    <student-list v-if="ready" :search_params="params"  :hide_create="hide_create" :version="version"  
        :can_select="listSettings.can_select" :title="listSettings.title"
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
                optionsSettings:{
                    empty_department:true,
                    empty_grade:true,
                    with_classes:true,
                    empty_classes:true
                },
                params:{
                    department:0,
                    grade:0,
                    classes:0,
                    removed:0
                },

                removed:false,

                listSettings:{
                    title:'',
                    can_select:false,
                }
              
                
             
            }
        },
        watch: {
            removed: function (value) {
                if(value){
                    this.params.removed=1
                }else{
                    this.params.removed=0
                } 
               this.setTitle()
            },
        },
        beforeMount() {
            this.init()
        },
        methods: {
            init(){
                this.setTitle()
            },
            setTitle(){
                 let text=  '  學生管理'
                 if(this.removed) text += ' (資源回收桶)'   
                 this.listSettings.title=Helper.getIcon(Student.title()) + text
            },
            onOptionsReady(params){
                this.params.department=params.department 
                this.params.grade=params.grade
                this.params.classes=params.classes
                this.ready=true
            },
            onSelected(student){
                this.$emit('selected',student.user_id)
            },
            onBeginCreate(){
                this.$emit('begin-create',this.student_id)
            },
            onBtnAddClicked(){

            }
            
            
        },

    }
</script>