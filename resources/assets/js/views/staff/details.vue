<template>
<div>
  <staff-view v-show="loaded" :id="id" :can_edit="can_edit" :can_back="can_back"  
     @saved="staffUpdated" @loaded="onDataLoaded" 
     @btn-back-clicked="onBtnBackClicked" @deleted="onStaffDeleted" > 

  </staff-view>
  
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
                 <!-- <grades-view :staff_id="id" v-if="activeIndex==0"></grades-view> -->
            </div>
           
        </div>
     </div>
  </div>
  
</div>
</template>

<script>
    import StaffView from '../../components/staff/view.vue'
    
    export default {
        name: 'DepartmentDetails',
        components: {
            'staff-view':StaffView,
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
               staff:null,
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
            onDataLoaded(staff){
                this.loaded=true
                this.staff=staff
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
            staffUpdated(){
               this.init()
            },
            onBtnBackClicked(){
                this.$emit('btn-back-clicked')
            },
            onStaffDeleted(){
               this.$emit('staff-deleted')
            },
            
        }, 

    }
</script>