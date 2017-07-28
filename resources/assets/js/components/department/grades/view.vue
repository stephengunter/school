<template>
<div>
    
    <list :department_id="department_id"
       :version="version"  @begin-edit="beginEdit" @loaded="onDataLoaded"
       @btn-back-clicked="onBtnBackClicked"   @btn-delete-clicked="beginDelete" >                 
    </list>
    <modal  :showbtn="false"   :title="editor.title" :show.sync="editor.show" 
            effect="fade" :width="editor.width"  
            @closed="editor.show=false">
        <div slot="modal-body" class="modal-body">
            <edit v-if="this.editor.show" :department_id="department_id"
            @canceled="onEditCanceled">
                
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
                readOnly:true,
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
            'id': 'init',
            'version':'init'
        },
        methods: {
            init() {
               this.readOnly=true
               this.deleteConfirm={
                    id:0,
                    show:false,
                    msg:''
               }
            },      
            onDataLoaded(department){
                this.$emit('loaded',department)
            },        
            beginEdit() {
                this.editor.show=true
            },
            onEditCanceled(){
                this.editor.show=false
            },
            onSaved(department){
                this.init()
                this.$emit('saved',department)
            },
            
            onBtnBackClicked(){
                this.$emit('btn-back-clicked')
            },
            beginDelete(values){
                this.deleteConfirm.msg= '確定要刪除部門 『' + values.name + '』嗎' 
                this.deleteConfirm.id=values.id
                this.deleteConfirm.show=true                
            },
            closeConfirm(){
                this.deleteConfirm.show=false
            },
            deleteDepartment(){
                let id = this.deleteConfirm.id 
                let remove= Department.delete(id)
                remove.then(result => {
                    Helper.BusEmitOK('刪除成功')
                    this.deleteConfirm.show=false
                    this.$emit('deleted')
                })
                .catch(error => {
                    Helper.BusEmitError(error,'刪除失敗')
                    this.closeConfirm()   
                })
            },
            
        }
    }
</script>
