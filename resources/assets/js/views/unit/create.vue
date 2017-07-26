<template>
    <edit
      @canceled="onCanceled" @saved="onSaved">
          
    </edit>
</template>

<script>
    import Edit from '../../components/unit/edit.vue'

    export default {
        name: 'UnitCreate',
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
            onSaved(unit){
                
                this.$emit('saved',unit)
            },
            
           
            
            
        },

    }
</script>