@extends('layouts.master')


@section('content')
        
       <tp-classes-index ></tp-classes-index> 
       
       
      
       
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

