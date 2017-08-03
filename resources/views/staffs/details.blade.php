@extends('layouts.master')

@section('content')

   <staff-details   :id="id" :can_back="can_back" 
     @staff-deleted="backToIndex"
     @btn-back-clicked="backToIndex"
     @edit-user="onEditUser">
     
   </staff-details>

   

@endsection


@section('scripts')


  <script>
     new Vue({
        el: '#content',
        data() {
            return {
               id:0,
               can_back:true
            }
        },
        beforeMount() {
            @if(isset($id))
              this.id= {{ $id }}

            @endif
        },
        methods: {
            onCourseDeleted(){
                this.backToIndex()
            },
            backToIndex(){
               Helper.redirect('/staffs')
            },
            onEditUser(user_id){
               Helper.newWindow('/users/' + user_id)
            }

        },
    

    })
  </script>


@endsection