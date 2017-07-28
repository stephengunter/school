<template>
<div>
    
    <list :department_id="department_id"
       :version="listSettings.version"  @begin-edit="beginEdit">     
    </list>
    <modal  :showbtn="false"   :title="editor.title" :show.sync="editor.show" 
            effect="fade" :width="editor.width"  
            @closed="editor.show=false">
        <div slot="modal-body" class="modal-body">
            <edit v-if="this.editor.show" :department_id="department_id"
            @saved="onSaved" @canceled="onEditCanceled">
                
            </edit>
        </div>
    </modal>
    
    

</div>
</template>
<script>
    import List from './list.vue'
    import Edit from './edit.vue'
 

    export default {
        name:'DepartmentGradesView',
        components: {
            List,
            Edit,
        },
        props: {
            department_id: {
              type: Number,
              default: 0
            },
            version: {
              type: Number,
              default: 0
            },
        },
        data() {
            return {
                
                listSettings:{
                    version:0
                },
                editor:{
                    title:'請選擇年級',
                    width:800,
                    show:false,
                    msg:'',
                }     
            }
        },
        beforeMount(){
            this.init()
        },
        watch: {
            version: function () {
                this.init()
                this.listSettings.version+=1
            }
        },
        methods: {
            init() {
               this.editor.show=false
            },      
            beginEdit() {
                this.editor.show=true
            },
            onEditCanceled(){
                this.editor.show=false
            },
            onSaved(department){
                 this.editor.show=false
                 this.listSettings.version += 1
            },
            
            
        }
    }
</script>
