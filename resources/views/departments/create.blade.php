@extends('layouts.master')

@section('content')

    <department-create @canceled="onCanceled" @saved="onSaved">
    </department-create>

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
            onSaved(department){
               let url='/departments/' + department.id
               Helper.redirect(url)
            },            
            backToIndex(){
                Helper.redirect('/departments')
            }

        },
    

    })
  </script>


@endsection