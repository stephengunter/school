@extends('layouts.master')


@section('content')
        
       <department-index v-show="!selected" 
           :version="version"
         @begin-create="onBeginCreate"  @selected="onSelected"  >
       </department-index> 

       

       <department-details v-if="selected"  :id="selected" :can_back="detailsSettings.can_back" 
          @btn-back-clicked="backToIndex" @department-deleted="backToIndex">
       </department-details>
      
       
@endsection



@section('scripts')


  <script>
     new Vue({
        el: '#content',
        data() {
            return {
               version:0,
              
               selected:0,
               
               indexSettings:{
                  hide_create:true, 
               },
               detailsSettings:{
                  can_back:true
               },
            }
        },
        computed: {
            indexMode() {
                 if(this.selected) return false
                  return true
            }
        },
        beforeMount() {
             
        },
        methods: {
            init(){
             
            },
            onBeginCreate(){
                let url=Department.createUrl()
                Helper.redirect(url)
            },        
            onSelected(id){
               this.selected=id
            },
            onDeleted(){
                this.backToIndex()
            },
            backToIndex(){
                this.version+=1
                this.selected=0                 
            },
            onSignupSelected(id){
               let url='/signups/' + id
               Helper.newWindow(url)
            },
            onEditUser(user_id){
               Helper.newWindow('/users/' + user_id)
            }
           
            

        },
    

    })
  </script>


@endsection

