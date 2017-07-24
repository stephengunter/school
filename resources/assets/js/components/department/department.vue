<template>
<div>
    <!-- <treeview :model="model"></treeview> -->
     <div class="panel panel-default show-data">
        <div class="panel-heading">
            <span class="panel-title">
                <h4>
                    <i class="fa fa-sitemap" aria-hidden="true"></i>
                    部門管理
                </h4>
             </span>
              
            <div>
                <!-- <button v-if="center.canEdit" v-show="canEdit" @click="btnEditCilcked" class="btn btn-primary btn-sm" >
                    <span class="glyphicon glyphicon-pencil"></span> 編輯
                </button>

                <button  v-if="center.canDelete" @click="beginDelete" class="btn btn-danger btn-sm" >
                    <span class="glyphicon glyphicon-trash"></span> 刪除
                </button> -->
               
            </div>
        </div>  <!-- End panel-heading-->
        <div class="panel-body">
            

       
        </div>  <!-- End panel-body-->

    </div>
</div>
</template>

<script>
    export default {
        name: 'Department',
        components: {
            
        },
        beforeMount() {
            this.init()
        },  
        data() {
            return {
                model:{
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
            }
        },
        methods: { 
            init(){
                this.fetchData()                
            },   
            fetchData() {
                let url = '/api/departments'
                axios.get(url)
                    .then(response => {
                        this.model=response.data.departmentList
                    })
                    .catch(error => {
                        console.log(error)
                    })
            },
            
        }

    }
</script>