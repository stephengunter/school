<template>
  <div class="dropdown">
    <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">Tutorials
    <span class="caret"></span></button>
    <ul class="dropdown-menu">
      <li><a tabindex="-1" href="#">HTML</a></li>
      <li><a tabindex="-1" href="#">CSS</a></li>
      <li class="dropdown-submenu">
        <a class="test" tabindex="-1" href="#">New dropdown <span class="caret"></span></a>
        <ul class="dropdown-menu" style="display: block;">
          <li><a tabindex="-1" href="#">2nd level dropdown</a></li>
          <li><a tabindex="-1" href="#">2nd level dropdown</a></li>
          <li class="dropdown-submenu">
            <a class="test" href="#">Another dropdown <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="#">3rd level dropdown</a></li>
              <li><a href="#">3rd level dropdown</a></li>
            </ul>
          </li>
        </ul>
      </li>
    </ul>
  </div>
</template>


<script>
    export default {
        name: 'LevelDropdown',
        props: {
            options: {
              type: Array,
              default: []
            },
            default: {
              type: String,
              default: ''
            },
        },
        data() {
            return {
               selectedItem:{},
               selectedId:'',
               loaded:false,
            }
        },
        beforeMount() {
            let item = this.options.find((item)=>{
              return item.id.toString() == this.default
            })
            if(item){
                this.selectedItem=item
                this.selectedId=item.id
            }else{
                this.selectedItem={}
                this.selectedId=''
            }

            this.loaded=true
            
        },
        methods: {
            onSelected(id){
                this.$emit('selected',id)
            }
        }




    }
</script>



<style scoped>
  .dropdown-submenu {
    position: relative;
  }

  .dropdown-submenu .dropdown-menu {
    top: 0;
    left: 100%;
    margin-top: -1px;
  }
</style>