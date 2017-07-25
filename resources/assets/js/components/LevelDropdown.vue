<template>
  <div class="dropdown">
    <button class="btn btn-default dropdown-toggle" 
       type="button" data-toggle="dropdown" aria-expanded="false">
         {{ title }}
      <span class="caret"></span>
    </button>
    <ul class="dropdown-menu">
      <level-dropdown-item v-for="item in options" :key="item.id"
        :item="item" :viewing="isViewing(item)"
         @extend="onExtended" @selected="onSelected">
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
            default_item: {
              type: Object,
              default: {}
            },
        },
        data() {
            return {
               viewing:'',
               loaded:false,
            }
        },
        computed:{
            title(){
               if(this.default_item) return this.default_item.text
                    else  return '  -----  '
            }    
        },
        beforeMount() {
         
            
        },
        methods: {
            onExtended(id){
               this.viewing=id
            },
            isViewing(item){
                return item.value==this.viewing
            },
            onSelected(item){
                this.$emit('selected',item)
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