<template>
   <li>
        <div>
            <a @click.prevent="onSelected(model.id)"> {{model.name}}  </a>
          
        </div>
        <ul  v-if="isFolder">
            <tree-item
                
                v-for="item in model.children"
                :model="item" :key="item.id" >
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
</style>