<template>
  <div class="dropdown">
    <button class="btn btn-default dropdown-toggle" 
       type="button" data-toggle="dropdown" aria-expanded="false">
         {{ title }}
      <span class="caret"></span>
    </button>
    <ul class="dropdown-menu">
      <level-dropdown-item v-for="item in options" 
        :item="item" :viewing="isViewing(item)" @extend="onExtended">
      </level-dropdown-item>
    </ul>

  </div>
</template>


<script>
    export default {
        name: 'LevelDropdown',
        props: {
            options: {
              type: Array
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
               viewing:'',
               loaded:false,
            }
        },
        computed:{
           title(){
               return 'test'
           }
        },
        beforeMount() {
          if(this.options){

          }else{

          }
            // let item = this.options.find((item)=>{
            //   return item.id.toString() == this.default
            // })
            // if(item){
            //     this.selectedItem=item
            //     this.selectedId=item.id
            // }else{
            //     this.selectedItem={}
            //     this.selectedId=''
            // }

            this.loaded=true
            
        },
        methods: {
            onExtended(id){
               this.viewing=id
            },
            isViewing(item){
                return item.value==this.viewing
            },
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