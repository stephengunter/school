<template>
  <div v-if="loaded" class="panel panel-default show-data">
      <div class="panel-heading">
          <span class="panel-title">
              <h4 v-html="title"></h4>
          </span>
          <div>
              <button  @click="beginEdit" class="btn btn-primary btn-sm" >
                  <span class="glyphicon glyphicon-pencil"></span> 編輯
              </button>
          </div>
      </div>  <!-- End panel-heading--> 
      
      <div v-if="loaded" class="panel-body">
          <table class="table table-striped">
              <tbody>
                   <tr v-for="grade in gradeList">
                      <td>{{ grade.name }}</td>
                  </tr> 
              </tbody> 
          </table>
       </div> <!-- End panel-body-->
       
  </div>
</template>

<script>
    export default {
        name: 'DepartmentGrade',
        props:{
            department_id:{
              type:Number,
              default:0
            },
            version:{
              type:Number,
              default:0
            }

        },
        data() {
            return {
               loaded:false,
               gradeList:[],

            }
        },
        computed:{
            title(){
                 return Helper.getIcon(Grade.title())  + '  年級管理'
            }, 
        },
        watch: {
            version: function () {
                 this.fetchData()
            },
        },
        beforeMount(){
           this.init()
        },
        methods: {
           init(){
              this.loaded=false

              this.fetchData()
              
           },
           fetchData() {
               
                let getData =DepartmentGrades.index(this.department_id)          
                
                getData.then(data => {
                   this.gradeList=data.grades
                   this.loaded = true                        
                })
                .catch(error=> {
                    Helper.BusEmitError(error)
                })
            },
            beginEdit(){
                this.$emit('begin-edit')                
            },
            
            
          
        }, 
    }
</script>
