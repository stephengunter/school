<template>
   
   <div  class="panel panel-default show-data">
      <div class="panel-heading">
          <span class="panel-title">
              <h4 v-html="title"></h4>
          </span>    
           
          <div>

             {{ total }}  個未同步的部門 &nbsp;
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
                <tr v-for="unit in units">
                    <td>
                      <checkbox :value="unit.id" :default="selected(unit.id)"
                        @selected="onSelected(unit.id)"   @unselected="onUnselected(unit.id)">
                         
                      </checkbox>
                    </td>
                    <td>
                       {{ unit.name }}
                    </td>
                    
                    
                     <td v-html="$options.filters.activeLabel(unit.active)" ></td>
                    
                    
                    <td>
                      <updated :entity="unit"></updated>
                    </td>
                </tr>                  
              </tbody>
          </table>
          
         
            
        
          
           
       
      </div><!-- End panel-body-->


    </div> 
</template>

<script>
    export default {
        name:'TPUnitIndexView',
        data() {
            return {
                loaded:false,

                title:Helper.getIcon(Unit.title())  + '  Teamplus部門同步',
                units:[],
                selected_ids:[],
            }
        },
        computed:{
            total(){
                return this.units.length
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
                this.units=[]
                this.selected_ids=[]

                this.fetchData()
            },
            fetchData() {
                let getData = TPUnit.index()             
             
                getData.then(data => {
                   this.units=data.units
                   let selected_ids=[]
                   for(let i=0; i<data.units.length; i++){
                         selected_ids.push(data.units[i].id)
                   }
                   this.selected_ids=selected_ids
                   this.loaded = true                        
                })
                .catch(error=> {
                    Helper.BusEmitError(error)
                })
            },
            selected(id){
               return ( this.selected_ids.indexOf(id) > -1 )
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
                let store=TPUnit.store(this.selected_ids)
               
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