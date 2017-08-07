<template>
   
   <div  class="panel panel-default show-data">
      <div class="panel-heading">
          <span class="panel-title">
              <h4 v-html="title"></h4>
          </span>    
           
          <div>

             {{ total }}  個未同步的學生 &nbsp;
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
                    <th>學號</th>
                    <th>科系</th>
                    <th>班級</th>
                    <th>狀態</th>
                </tr>      
             </thead>
             <tbody>
                <tr v-for="student in students">
                    <td>
                      <checkbox :value="student.user_id" :default="selected(student.user_id)"
                        @selected="onSelected(student.user_id)"   @unselected="onUnselected(student.user_id)">
                         
                      </checkbox>
                    </td>
                    <td>  {{ student.user.profile.fullname }} </td>
                    <td v-text="student.number"></td> 
                    <td v-text="student.department.name"></td>
                    <td v-text="student.class.name"></td> 
                    <td v-if="removed(student.removed)" v-html="$options.filters.removedLabel(student.removed)" ></td>
                    <td v-else v-html="studentActiveLabel(student.active)" ></td> 
                   
                </tr>                  
              </tbody>
          </table>
          
         
            
        
          
           
       
      </div><!-- End panel-body-->
      

    </div> 
</template>

<script>
    export default {
        name:'TPStudentIndexView',
        data() {
            return {
                loaded:false,

                title:Helper.getIcon(Student.title())  + '  Teamplus學生同步',
                students:[],
                selected_ids:[],
            }
        },
        computed:{
            total(){
                return this.students.length
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
                this.students=[]
                this.selected_ids=[]

                this.fetchData()
            },
            fetchData() {
                let getData = TPStudent.index()             
             
                getData.then(data => {
                   this.students=data.students
                   let selected_ids=[]
                   for(let i=0; i<data.students.length; i++){
                         selected_ids.push(data.students[i].user_id)
                   }
                   this.selected_ids=selected_ids
                   this.loaded = true                        
                })
                .catch(error=> {
                    Helper.BusEmitError(error)
                })
            },
            studentActiveLabel(active){
                 return Student.activeLabel(active)
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
                let store=TPStudent.store(this.selected_ids)
               
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