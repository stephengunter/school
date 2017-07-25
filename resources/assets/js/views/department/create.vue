<template>
    <edit
      @canceled="onCanceled" @saved="onSaved">
          
    </edit>
</template>

<script>
    import Edit from '../../components/department/edit.vue'

    export default {
        name: 'DepartmentCreate',
        components: {
            Edit
        },
        data() {
            return {
                
                
             
            }
        },
        beforeMount() {
             this.init()
        },
        methods: {
            init(){
                
             
            },
            onCanceled(){
                this.$emit('canceled')
            },
            onSaved(department){
                
                this.$emit('saved',department)
            },
            
           
            
            
        },

    }
</script>