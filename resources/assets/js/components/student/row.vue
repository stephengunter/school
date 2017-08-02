<template>
   <tr>
        <td v-if="can_remove">
            <button @click="removeItem(student.id,student.name)" class="btn btn-danger btn-xs">
             <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
            </button>
        </td>
        <td v-if="select">
             <checkbox :default="been_selected"
              @selected="selected"
              @unselected="unselected" >
             </checkbox>
        </td>
        
        <td>
            <a herf="#" @click.prevent="selected">
                   {{ student.name }}
            </a>
        </td> 
        <td v-text="student.number"></td> 
        <td v-text="student.department.name"></td> 
         <td v-text="student.class.name"></td> 
        <td v-if="removed" v-html="$options.filters.removedLabel(student.removed)" ></td>
        <td v-else v-html="studentActiveLabel()" ></td> 
        <td>
            <updated :entity="student"></updated>
        </td>    
       

        
    </tr>                   
       
</template>
<script>
  
    export default {
        name: 'StudentRow',
        props: {
            student: {
               type: Object,
               default: null
            },
            more:{
               type: Boolean,
               default: false
            },
            can_remove:{
               type: Boolean,
               default: false
            },
            removed:{
               type: Boolean,
               default: false
            },
            select:{
               type: Boolean,
               default: false
            },
            been_selected:{
                type: Boolean,
               default: false
            }
            
        },
        data() {
            return {
                thead:[],
            }
        },
        beforeMount(){
            
        },
        
        methods: {
            
            removeItem(id,name){
                let values={
                    id:id,
                    name:name
                }
                this.$emit('remove-clicked',values)
            },
            studentActiveLabel(){
                let active=this.student.active
                 return Student.activeLabel(active)
            },
            selected(){
                this.$emit('selected',this.student)
            },
            unselected(){
                 this.$emit('unselected',this.student.id)
            }
            
            
        },
        
    }
</script>