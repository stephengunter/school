<template>
<div>
  <department v-show="loaded" :id="id" :can_edit="can_edit" :can_back="can_back"  
     @saved="departmentUpdated" @loaded="onDataLoaded" 
     @btn-back-clicked="onBtnBackClicked" @deleted="onDepartmentDeleted" > 

  </department>
  
  <div v-if="loaded" class="panel with-nav-tabs panel-default">
     <div class="panel-heading">
         <ul class="nav nav-tabs">
            <li class="active">
                <a @click="activeIndex=0" href="#grades" data-toggle="tab">年級</a>
            </li>
            <li>
                <a @click="activeIndex=1" href="#classes" data-toggle="tab">班級</a>
            </li>
         </ul>
     </div>
     <div class="panel-body">
        <div class="tab-content">
            <div class="tab-pane fade active in" id="grades">
                 <grades-view :department_id="id" v-if="activeIndex==0"></grades-view>
            </div>
            <div class="tab-pane fade" id="classes">
                 <class-list v-if="activeIndex==1" :department_id="id"></class-list>
             </div>
        </div>
     </div>
  </div>
  
</div>
</template>

<script>
    import DepartmentComponent from '../../components/department/department.vue'
    import GradesView from '../../components/department/grades/view.vue'
    import ClassList from '../../components/class/list.vue'
    
    export default {
        name: 'DepartmentDetails',
        components: {
            'department':DepartmentComponent,
            'grades-view':GradesView,
            'class-list':ClassList,
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
               department:null,
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
            onDataLoaded(department){
                this.loaded=true
                this.department=department
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
            departmentUpdated(){
               this.init()
            },
            onBtnBackClicked(){
                this.$emit('btn-back-clicked')
            },
            onDepartmentDeleted(){
               this.$emit('department-deleted')
            },
            
        }, 

    }
</script>