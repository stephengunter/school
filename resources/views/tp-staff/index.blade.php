@extends('layouts.master')


@section('content')
        
       <tp-staff-index ></tp-staff-index> 
       
       
      
       
@endsection



@section('scripts')


  <script>
     new Vue({
        el: '#content',
        data() {
            return {
            }
        },
        beforeMount() {
             
        },
        methods: {
            init(){
             
            },
            
           
            

        },
    

    })
  </script>


@endsection

