<template>
   <ul v-if="model">
       <tree-item   class="item"  :model="model"
       @selected="onSelected">
       </tree-item>
   </ul>
</template>


<script>
    export default {
        name: 'TreeView',
        props: {
            model: Object
        },
        data() {
            return {
                treeData: {}
            }
        },
        beforeMount() {
            
        },
        methods: {
            onSelected(id){
                this.$emit('selected',id)
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
    .item {
      cursor: pointer;
    }
</style>