<template>
    <ul>
       <tree-view-item class="item" :model="testData" expand="true"></tree-view-item>
    </ul>
    <!-- <ul>

       <item class="item" :model="model"> </item>
    </ul> -->
</template>

<script>
   
    export default {
        name: 'TreeView',
        props: ['model'],
        data(){
          return {
            testData:{}
          }
        },
        beforeMount() {
           this.init();
        },
        methods:{
           init(){
            var data = {
                name: 'My Tree',
                children: [
                  { name: 'hello' },
                  { name: 'wat' },
                  {
                    name: 'child folder',
                    children: [
                      {
                        name: 'child folder',
                        children: [
                          { name: 'hello' },
                          { name: 'wat' }
                        ]
                      },
                      { name: 'hello' },
                      { name: 'wat' },
                      {
                        name: 'child folder',
                        children: [
                          { name: 'hello' },
                          { name: 'wat' }
                        ]
                      }
                    ]
                  }
                ]
              }

              this.testData=data
           }
        }

    }
</script>

<style scoped>
    .item {
      cursor: pointer;
    }
</style>