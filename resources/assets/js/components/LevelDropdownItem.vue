<template>
    <li v-if="hasChildren" class="dropdown-submenu">
       <a href="#">{{ item.text }} <span @mouseover="onExtend" class="caret"></span> </a> 
       <ul class="dropdown-menu" :style="toggleStyle">
           <!-- <level-dropdown-item v-for="child in item.childrenOptions" 
           :item="child" :extend="extend">
             
           </level-dropdown-item>
 -->
           <level-dropdown-item v-for="child in item.childrenOptions" 
            :item="child" :viewing="isViewing(child)" @extend="onChildrenExtended">
           </level-dropdown-item>
       </ul>
    </li>

    <li v-else >
      <a href="#">{{ item.text }}</a>
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
               selectedItem:{},
               selectedId:'',
               loaded:false,
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
            onExtend(){
              this.extend=true
              this.$emit('extend',this.item.value)
            },
            onChildrenExtended(id){
                this.viewingId=id
            },
            isViewing(item){
                return item.value==this.viewingId
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