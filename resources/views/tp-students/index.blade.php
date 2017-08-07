@extends('layouts.master')


@section('content')
        
       <tp-student-index ></tp-student-index> 
       
       
      
       
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

