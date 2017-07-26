@extends('layouts.master')

@section('content')

    <unit-create @canceled="onCanceled" @saved="onSaved">
    </unit-create>

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
            onSaved(unit){
               let url='/units/' + unit.id
               Helper.redirect(url)
            },            
            backToIndex(){
                Helper.redirect('/units')
            }

        },
    

    })
  </script>


@endsection