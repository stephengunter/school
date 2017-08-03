@extends('layouts.master')

@section('content')

    <student-create @canceled="onCanceled" 
    @saved="onSaved" @imported="onImported">
    </student-create>

@endsection


@section('scripts')


  <script>
     new Vue({
        el: '#content',
        data() {
            return {
              

               
            }
        },
        methods: {
            onCanceled(){
               this.backToIndex()
            },
            onSaved(course){
               let url='/courses/' + course.id
               Helper.redirect(url)
            },            
            backToIndex(){
                Helper.redirect('/courses')
            },
            onImported(){
               this.backToIndex()
            }

        },
    

    })
  </script>


@endsection