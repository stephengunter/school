<template>
<div>
  <department v-show="loaded" :id="id" :can_edit="can_edit" :can_back="can_back"  
     @saved="departmentUpdated" @loaded="onDataLoaded" 
     @btn-back-clicked="onBtnBackClicked" @deleted="onDepartmentDeleted" > 

  </department>
  
  
  
</div>
</template>

<script>
    import DepartmentComponent from '../../components/department/department.vue'
    
    export default {
        name: 'DepartmentDetails',
        components: {
            'department':DepartmentComponent,
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