<template>
   <tr>
        <td v-if="can_remove">
            <button @click="removeItem(staff.id,staff.name)" class="btn btn-danger btn-xs">
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
                   {{ staff.name }}
            </a>
        </td> 
        <td v-text="staff.number"></td> 
        <td v-text="staff.unit.name"></td> 
        <td v-if="removed" v-html="$options.filters.removedLabel(staff.removed)" ></td>
        <td v-else v-html="staffActiveLabel()" ></td> 
        <td>
            <updated :entity="staff"></updated>
        </td>    
       

        
    </tr>                   
       
</template>
<script>
  
    export default {
        name: 'StaffRow',
        props: {
            staff: {
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
            staffActiveLabel(){
                let status=this.staff.status
                 return Staff.activeLabel(status)
            },
            selected(){
                this.$emit('selected',this.staff)
            },
            unselected(){
                 this.$emit('unselected',this.staff.id)
            }
            
            
        },
        
    }
</script>