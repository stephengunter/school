@extends('layouts.master')

@section('content')
  
   <tree-view></tree-view>

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
            

        },
    

    })
  </script>


@endsection