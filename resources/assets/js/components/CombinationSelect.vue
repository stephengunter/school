<template>
    <div class="form-inline">
       <div class="form-group">
            <select  v-model="params.department" @change="onDepartmentChanged"  style="width:auto;" class="form-control selectWidth">
                <option v-for="item in departmentOptions" :value="item.value" v-text="item.text"></option>
            </select>
       </div>
       <div class="form-group">
            <select  v-model="params.grade" @change="onGradeChanged"    style="width:auto;" class="form-control selectWidth">
                 <option v-for="item in gradeOptions" :value="item.value" v-text="item.text"></option>
            </select>
       </div>
       <div v-if="with_classes" v-show="showClass" class="form-group">
            <select  v-model="params.classes" @change="onClassChanged"    style="width:auto;" class="form-control selectWidth">
                 <option v-for="item in classOptions" :value="item.value" v-text="item.text"></option>
            </select>
       </div>
       
    </div>

</template>

<script>
    export default {
        name: 'CombinationSelect',  
        props: {
            with_classes: {
              type: Boolean,
              default: false
            },
            empty_department: {
              type: Boolean,
              default: false
            },
            empty_grade: {
              type: Boolean,
              default: false
            },
            empty_classes: {
              type: Boolean,
              default: false
            },
            version: {
              type: Number,
              default: 0
            },
        },
        data() {
            return {
                ready:false,
                departmentOptions:[],
                gradeOptions:[],
                classOptions:[],
                params:{
                    department:0,
                    grade:0,
                    classes:0,
                },
             
            }
        },
        computed:{
           showClass(){
             if(!this.params.department) return false
              return this.params.grade > 0
           }
        },
        watch: {
            ready: function (val) {
              if(this.ready){
                 this.$emit('ready', this.params)
              }
            },
        },
        beforeMount() {
            this.init()
        },
        methods: {
            init(){
                this.ready=false

                let options=Student.indexOptions(this.params)
                options.then(data => {
                    this.departmentOptions = data.departmentOptions
                    if(this.empty_department){
                       let allDepartments={ text:'全部科系' , value:'0' }
                       this.departmentOptions.splice(0, 0, allDepartments)
                    }
                   

                    this.gradeOptions = data.gradeOptions 
                    if(this.empty_grade){
                       let allGrades={ text:'所有年級' , value:'0' }
                       this.gradeOptions.splice(0, 0, allGrades)
                    }                       
                    

                    this.classOptions = data.classOptions 
                    if(this.empty_classes){
                       let allClasses={ text:'所有班級' , value:'0' }
                       this.classOptions.splice(0, 0, allClasses)
                    }       

                    this.ready=true

                })
                .catch(error => {
                    Helper.BusEmitError(error)
                    this.ready=false
                })
             
            },
           
            onDepartmentChanged(){
               this.params.grade=0
               this.params.classes=0
               this.init()
             
            },
            onGradeChanged(){
               this.params.classes=0
               this.init()
             
            },
            onClassChanged(){
               this.init()
            },
            
        },

    }
</script>