<template>
<div>
  <student-view v-show="loaded" :id="id" :can_edit="can_edit" :can_back="can_back"  
     @saved="studentUpdated" @loaded="onDataLoaded" 
     @btn-back-clicked="onBtnBackClicked" @deleted="onDepartmentDeleted" > 

  </student-view>
  
  <div v-if="loaded" class="panel with-nav-tabs panel-default">
     <div class="panel-heading">
         <ul class="nav nav-tabs">
            <li class="active">
                <a @click="activeIndex=0" href="#grades" data-toggle="tab">年級</a>
            </li>
           
         </ul>
     </div>
     <div class="panel-body">
        <div class="tab-content">
            <div class="tab-pane fade active in" id="grades">
                 <!-- <grades-view :student_id="id" v-if="activeIndex==0"></grades-view> -->
            </div>
           
        </div>
     </div>
  </div>
  
</div>
</template>

<script>
    import StudentView from '../../components/student/view.vue'
    
    export default {
        name: 'DepartmentDetails',
        components: {
            'student-view':StudentView,
        },
        props: {
            id: {
              type: Number,
              default: 0
            },
            version: {
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
        },
        data() {
            return {
               loaded:false,
               student:null,
               current_version:0,

               activeIndex:0,

            }
        },
        
        beforeMount(){
           this.init()
        },
        methods: {
            init(){
              this.loaded=false
              this.readonly=true
              this.activeIndex=0
            },
            toBoolean(val){
               return val=='true'
            },
            onDataLoaded(student){
                this.loaded=true
                this.student=student
            },
            btnEditClicked(){    
              this.beginEdit()
            },
            beginEdit(){
               this.readonly=false
            },
            editCanceled(){
               this.readonly=true
            },
            studentUpdated(){
               this.init()
            },
            onBtnBackClicked(){
                this.$emit('btn-back-clicked')
            },
            onDepartmentDeleted(){
               this.$emit('student-deleted')
            },
            
        }, 

    }
</script>