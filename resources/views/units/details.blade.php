@extends('layouts.master')

@section('content')

    <unit-details :id="id" :can_back="can_back" 
      @btn-back-clicked="backToIndex" @unit-deleted="onUnitDeleted">           
    </unit-details>

          

   

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
            onUnitDeleted(){
                this.backToIndex()
            },
            backToIndex(){
              let url=Unit.source()
               Helper.redirect(url)
            }

        },
    

    })
  </script>


@endsection