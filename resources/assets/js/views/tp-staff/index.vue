<template>
   
   <div  class="panel panel-default show-data">
      <div class="panel-heading">
          <span class="panel-title">
              <h4 v-html="title"></h4>
          </span>    
           
          <div>

             {{ total }}  個未同步的教職員 &nbsp;
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
                    <th>姓名</th>
                    <th>教職員編號</th>
                    <th>單位</th>
                </tr>      
             </thead>
             <tbody>
                <tr v-for="staff in staffs">
                    <td>
                      <checkbox :value="staff.user_id" :default="selected(staff.user_id)"
                        @selected="onSelected(staff.user_id)"   @unselected="onUnselected(staff.user_id)">
                         
                      </checkbox>
                    </td>
                    <td>  {{ staff.user.profile.fullname }} </td>
                    <td v-text="staff.number"></td> 
                    <td v-text="staff.unit.name"></td>
                   
                    <td v-if="removed(staff.removed)" v-html="$options.filters.removedLabel(staff.removed)" ></td>
                    <td v-else v-html="staffActiveLabel(staff.status)" ></td> 
                   
                </tr>                  
              </tbody>
          </table>
          
         
            
        
          
           
       
      </div><!-- End panel-body-->
      

    </div> 
</template>

<script>
    export default {
        name:'TPStaffIndexView',
        data() {
            return {
                loaded:false,

                title:Helper.getIcon(Staff.title())  + '  Teamplus教職員同步',
                staffs:[],
                selected_ids:[],
            }
        },
        computed:{
            total(){
                return this.staffs.length
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
                this.staffs=[]
                this.selected_ids=[]

                this.fetchData()
            },
            fetchData() {
                let getData = TPStaff.index()             
             
                getData.then(data => {
                   this.staffs=data.staffs
                   let selected_ids=[]
                   for(let i=0; i<data.staffs.length; i++){
                         selected_ids.push(data.staffs[i].user_id)
                   }
                   this.selected_ids=selected_ids
                   this.loaded = true                        
                })
                .catch(error=> {
                    Helper.BusEmitError(error)
                })
            },
            staffActiveLabel(status){
                 return Staff.activeLabel(status)
            },
            removed(val){
                return Helper.isTrue(val)
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
                let store=TPStaff.store(this.selected_ids)
               
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