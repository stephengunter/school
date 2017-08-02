@extends('layouts.master')


@section('content')
        
       <tp-department-index ></tp-department-index> 
       
       
      
       
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

