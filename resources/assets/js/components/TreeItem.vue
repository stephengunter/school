<template>
   <li>
        <div>
            <a @click.prevent="onSelected(model)"> {{model.name}}  </a>
          
        </div>
        <ul  v-if="isFolder">
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
            model: Object
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
        methods: {
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