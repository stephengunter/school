@extends('layouts.master')

@section('content')

    <department-details :id="id" :can_back="can_back" 
      @btn-back-clicked="backToIndex" @department-deleted="onDepartmentDeleted">           
    </department-details>

          

   

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
            onDepartmentDeleted(){
                this.backToIndex()
            },
            backToIndex(){
               Helper.redirect('/departments')
            }

        },
    

    })
  </script>


@endsection