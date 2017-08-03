<template>
<div>
    <div class="panel panel-default">
        <div class="panel-heading">
              <level-dropdown :default_item="selectedUnit" :options="unitOptions"
                      @selected="onUnitSelected" >
              </level-dropdown>
            <div v-if="removed">
                <button @click="removed=false" class="btn btn-default btn-sm" >
                     <span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span>
                     返回
                </button>

            </div>
            <div v-else>
              <button  @click="removed=true" class="btn btn-default btn-sm" >
                  <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                  資源回收桶
              </button>
              &nbsp;
              
              <button  @click="onBtnAddClicked" class="btn btn-primary btn-sm" >
                  <span class="glyphicon glyphicon-plus"></span> 新增
              </button>

          </div>
        </div>
        
    </div>
     
    <staff-list v-if="ready" :search_params="params"  :hide_create="hide_create" :version="version"  
        :can_select="listSettings.can_select" :title="listSettings.title"
        @selected="onSelected" @begin-create="onBeginCreate">
    </staff-list>

</div>

</template>

<script>
    import StaffList from '../../components/staff/list.vue'
    

    export default {
        name: 'StaffIndex',       
        components: {
            'staff-list':StaffList
        },
        props: {
            version: {
              type: Number,
              default: 0
            },
            hide_create:{
               type: Boolean,
               default: false
            }
        },
        data() {
            return {
                ready:false,

                selectedUnit:{},

                unitOptions:[],

                params:{
                    unit:0,
                    removed:0
                },

                removed:false,

                listSettings:{
                    title:'',
                    can_select:false,
                }
              
                
             
            }
        },
        watch: {
            removed: function (value) {
                if(value){
                    this.params.removed=1
                }else{
                    this.params.removed=0
                } 
               this.setTitle()
            },
        },
        beforeMount() {
            this.init()
        },
        methods: {
            init(){
                this.setTitle()
                
                let options=Staff.indexOptions()
                options.then(data => {
                    this.unitOptions=data.unitOptions
                    let rootOption={
                        text:' 所有部門 ',
                        value: 0,
                    }
                    this.unitOptions.splice(0, 0, rootOption);

                    this.onUnitSelected(rootOption)
                    this.ready=true
                })
                .catch(error => {
                    Helper.BusEmitError(error)                   
                    this.ready=false
                })

            },
            setTitle(){
                 let text=  '  員工管理'
                 if(this.removed) text += ' (資源回收桶)'   
                 this.listSettings.title=Helper.getIcon(Staff.title()) + text
            },
            onUnitSelected(item){
                this.selectedUnit=item
                this.params.unit=item.value
            },
            onOptionsReady(params){
                this.params.department=params.department 
                this.params.grade=params.grade
                this.params.classes=params.classes
                this.ready=true
            },
            onSelected(staff){
                this.$emit('selected',staff.user_id)
            },
            onBeginCreate(){
                this.$emit('begin-create',this.staff_id)
            },
            onBtnAddClicked(){

            }
            
            
        },

    }
</script>