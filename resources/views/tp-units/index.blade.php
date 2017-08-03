@extends('layouts.master')


@section('content')
        
       <tp-unit-index ></tp-unit-index> 
       
       
      
       
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

