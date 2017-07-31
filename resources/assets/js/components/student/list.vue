<template>
    <data-viewer  :default_search="defaultSearch" :default_order="defaultOrder"
      :source="source" :search_params="search_params"  :thead="thead" :no_search="can_select"  
      :filter="filter"  :title="title" create_text="" 
      :show_title="show_title"  :no_page="no_page" 
      @refresh="init" :version="version"   @beginCreate="beginCreate"
       @dataLoaded="onDataLoaded">
        <!--  <div  class="form-inline" slot="header">
               
                <button v-show="hasData" class="btn btn-default btn-xs" @click.prevent="onBtnViewMoreClicked">
                    <span v-if="viewMore" class="glyphicon glyphicon-step-backward" aria-hidden="true"></span>
                    <span v-if="!viewMore" class="glyphicon glyphicon-step-forward" aria-hidden="true"></span>
                </button>
         </div> -->
         <button v-if="!search_params.removed" v-show="hasData" slot="btn"  class="btn btn-warning btn-sm" >
               <i class="fa fa-file-excel-o" aria-hidden="true"></i>
                 匯出 
         </button>

       
         
         <template scope="props">
            <row :student="props.item" :more="viewMore" :select="can_select"
               :removed="removed"
               :been_selected="beenSelected(props.item.id)"       
               @selected="onRowSelected"
               @unselected ="onRowUnselected">
                
            </row>
            
        </template>

    </data-viewer>

</template>

<script>
    import Row from '../../components/student/row.vue'
   
    export default {
        components: {
            Row
        },
        name: 'StudentList',
        props: {
            search_params: {
              type: Object,
              default: null
            },
            hide_create: {
              type: Boolean,
              default: false
            },
            version:{
               type: Number,
               default: 0
            },
            can_select:{
               type: Boolean,
               default: true
            },
            selected_ids: {
              type: Array,
              default: null
            },
            show_title:{
               type: Boolean,
               default: true
            },
            title:{
               type: String,
               default: ''
            },
            no_page:{
               type: Boolean,
               default: false
            },
        },
        beforeMount() {
           this.init()
        },
        data() {
            return {
                loaded:false,
                source: Student.source(),
                
                defaultSearch:'user.profile.fullname',
                defaultOrder:'updated_at',                      
                create: Student.createUrl(),
                
                thead:[],
                filter: [{
                    title: '姓名',
                    key: 'user.profile.fullname',
                },{
                    title: '學號',
                    key: 'number',
                }],
  
                
                hasData:false,
                viewMore:false,


              
             
            }
        },
        computed:{
           removed(){
               return  Helper.isTrue(this.search_params.removed)
           }
        },     
        methods: {
            init() {
                this.thead=Student.getThead(this.can_select)  
            },
            onDataLoaded(data){
                this.hasData=data.model.total > 0
            },
            onBtnViewMoreClicked(){
                this.viewMore=!this.viewMore
                for (var i = this.thead.length - 1; i >= 0; i--) {
                    if(!this.thead[i].static){
                        this.thead[i].default = !this.thead[i].default
                    }
                    
                }
            },
            onRowSelected(id,number,name){
                this.$emit('selected',id,number,name)
            },
            onRowUnselected(id){
                this.$emit('unselected',id)
            },
            beginCreate(){
                 this.$emit('begin-create')
            },
            beenSelected(id){
                if(!this.selected_ids) return false
                if(this.selected_ids.length < 1)  return false
                 let index = this.selected_ids.indexOf(id)
                return index >= 0
            }
            
           
        },

    }
</script>