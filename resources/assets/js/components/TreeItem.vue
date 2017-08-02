<template>
   <li>
        <div>
            <a @click.prevent="onSelected(model)"> {{model.name}}  </a>
            <span v-if="isFolder" @click.prevent="toggle">[{{open ? '-' : '+'}}]</span>
        </div>
        <ul  v-if="isFolder" v-show="open">
            <tree-item
                
                v-for="item in model.children"
                :model="item" :key="item.id" 
                @selected="onSelected">
            </tree-item>
          
        </ul>
    </li>
</template>


<script>
    export default {
        name: 'TreeItem',
        props: {
            model: Object,
            is_open:{
              type:Boolean,
              default:false
            }
        },
        data() {
            return {
                open: false
            }
        },
        computed: {
            isFolder() {
              return this.model.children &&
                this.model.children.length
            }
        },
        beforeMount(){
           this.init()
        },
        methods: {
            init(){
                this.open=this.is_open
            },
            toggle(){
                this.open = !this.open
            },
            onSelected(model){
                this.$emit('selected',model)
            }
        }




    }
</script>



<style scoped>
    ul {
      padding-left: 1em;
      line-height: 1.5em;
      list-style-type: dot;
    }
</style>