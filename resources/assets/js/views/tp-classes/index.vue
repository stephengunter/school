<template>
   
   <div  class="panel panel-default show-data">
      <div class="panel-heading">
          <span class="panel-title">
              <h4 v-html="title"></h4>
          </span>    
           
          <div>

             {{ total }}  個未同步的班級 &nbsp;
             已選擇：<span v-text="selectedCount" style="color:blue"></span> &nbsp;
             
              <button v-show="selectedCount>0" @click="onSubmit" class="btn btn-success btn-sm" >
                執行同步
              </button>

          </div>
      </div>  <!-- End panel-heading--> 
      <div class="panel-body">
          <table  class="table table-striped">
              <thead>
                <tr>
                    <th></th>
                    <th>名稱</th>
                    <th>狀態</th>
                    <th>最後更新</th>
                </tr>      
             </thead>
             <tbody>
                <tr v-for="entity in entityList">
                    <td>
                      <checkbox :value="entity.id" :default="selected(entity.id)"
                        @selected="onSelected(entity.id)"   @unselected="onUnselected(entity.id)">
                         
                      </checkbox>
                    </td>
                    <td>
                       {{ entity.name }}
                    </td>
                    
                    
                     <td v-html="$options.filters.activeLabel(entity.active)" ></td>
                    
                    
                    <td>
                      <updated :entity="entity"></updated>
                    </td>
                </tr>                  
              </tbody>
          </table>
          
         
            
        
          
           
       
      </div><!-- End panel-body-->


    </div> 
</template>

<script>
    export default {
        name:'TPClassIndexView',
        data() {
            return {
                loaded:false,

                title:Helper.getIcon(Classes.title())  + '  Teamplus班級同步',
                entityList:[],
                selected_ids:[],
            }
        },
        computed:{
            total(){
                return this.entityList.length
            },
            selectedCount(){
                return this.selected_ids.length
            }
        },
        beforeMount(){
           this.init()
        },
        methods: {
            init(){
                this.loaded=false
                this.entityList=[]
                this.selected_ids=[]

                this.fetchData()
            },
            fetchData() {
                let getData = TPClasses.index()             
             
                getData.then(data => {
                   this.entityList=data.classesList
                   this.loaded = true                        
                })
                .catch(error=> {
                    Helper.BusEmitError(error)
                })
            },
            selected(id){
               return ( this.selected_ids.indexOf(id) > 0 )
            },
            onSelected(id){
                if(!this.selected(id)){
                    this.selected_ids.push(id)
                }
                
            },
            onUnselected(id){
                let index=this.selected_ids.indexOf(id)
                if(index > -1){
                    this.selected_ids.splice(index, 1)
                }
            },
            onSubmit(){
                let store=TPClasses.store(this.selected_ids)
               
                store.then(data => {
                   Helper.BusEmitOK()
                   this.init()                           
                })
                .catch(error => {
                    Helper.BusEmitError(error) 
                })
            }
            
        }
    }
</script>