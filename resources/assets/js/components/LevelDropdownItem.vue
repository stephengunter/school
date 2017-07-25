<template>
    <li v-if="hasChildren" class="dropdown-submenu">
       <a href="#" @click.prevent="onSelected">{{ item.text }} <span @mouseover="onExtend" class="caret"></span> </a> 
       <ul class="dropdown-menu" :style="toggleStyle">
           <level-dropdown-item v-for="child in item.childrenOptions" :key="child.id" 
            :item="child" :viewing="isViewing(child)" 
            @extend="onChildrenExtended" @selected="onChildSelected">
           </level-dropdown-item>
       </ul>
    </li>

    <li v-else >
      <a href="#" @click.prevent="onSelected">{{ item.text }}</a>
   </li>
</template>


<script>
    export default {
        name: 'LevelDropdownItem',
        props: {
            item: {
              type: Object,
              default:{}
            },
            default: {
              type: String,
              default: ''
            },
            viewing:{
              type: Boolean,
              default: false
            }
           
        },
        data() {
            return {
               viewingId:'',
               extend:false,
            }
        },
        
        computed:{
           title(){
               return 'test'
           },
           hasChildren(){
              if(this.item){
                 if(this.item.childrenOptions){
                    return this.item.childrenOptions.length > 0
                 }else{
                    return false
                 } 
              }
              return false
           },
           toggleStyle(){
              if(this.extend && this.viewing)  return 'display: block;'
              return ''
             
           }
        },
        beforeMount() {

            
        },
        methods: {
            onExtend(){
              this.extend=!this.extend
              this.$emit('extend',this.item.value)
            },
            onChildrenExtended(id){
                this.viewingId=id
            },
            isViewing(item){
                return item.value==this.viewingId
            },
            onSelected(){
                this.$emit('selected',  this.item)
            },
            onChildSelected(item){
                this.$emit('selected',  item)
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