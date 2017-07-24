<template>
<div>
  
            
</div>
    <!-- <ul>

       <item class="item" :model="model"> </item>
    </ul> -->
</template>

<script>
   
    export default {
        name: 'TreeView',
        props: ['model'],
        components: {
           
          // 'item' : TreeViewItem
        },
        created() {
           Helper.BusEmitOK('test')
        },
        data(){
          return {
            showUpdatedBy:true
          }
        }

    }
</script>

<style scoped>
    .item {
      cursor: pointer;
    }
</style>