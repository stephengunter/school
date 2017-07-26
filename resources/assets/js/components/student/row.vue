<template>
   <tr>
        <td v-if="remove">
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
        <td v-html="$options.filters.activeLabel(student.active)"></td> 
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
            remove:{
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
            selected(){
                this.$emit('selected',this.student)
            },
            unselected(){
                 this.$emit('unselected',this.student.id)
            }
            
            
        },
        
    }
</script>