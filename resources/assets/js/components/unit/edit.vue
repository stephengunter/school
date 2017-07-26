<template>

    <div class="panel panel-default">
        
        <div class="panel-heading">    
             <span class="panel-title">
                  <h4 v-html="title"></h4>
             </span>           
        </div>
        <div  v-if="loaded"  class="panel-body">  
            <form class="form" @submit.prevent="onSubmit" @keydown="clearErrorMsg($event.target.name)">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">                           
                            <label>名稱</label>
                            <input type="text" name="unit.name" class="form-control" v-model="form.unit.name"  >
                            <small class="text-danger" v-if="form.errors.has('unit.name')" v-text="form.errors.get('unit.name')"></small>
                        </div>
                    </div>
                    <div class="col-sm-3">
                         <div class="form-group">                           
                            <label>代碼</label>
                            <input type="text" name="unit.code" class="form-control" v-model="form.unit.code"  >
                            <small class="text-danger" v-if="form.errors.has('unit.code')" v-text="form.errors.get('unit.code')"></small>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">                           
                            <label>母部門</label>
                            <div>
                            <input type="hidden" v-model="form.unit.parent"  >
                                <level-dropdown :default_item="selectedUnit" :options="unitOptions"
                                   @selected="onUnitSelected" >
                                </level-dropdown>
                            </div>
                        </div>  
                    </div>
                    
                </div>
                <div class="row">
                    <div class="col-sm-3">
                         <div v-if="entityRemoved" class="form-group">                           
                            <label>已移除</label>
                            <div>
                               <input type="hidden" v-model="form.unit.removed"  >
                               <toggle :items="removedOptions"   :default_val="form.unit.removed" @selected=setRemoved></toggle>
                            </div>
                        </div>
                        <div v-else class="form-group">                           
                            <label>狀態</label>
                            <div>
                               <input type="hidden" v-model="form.unit.active"  >
                               <toggle :items="activeOptions"   :default_val="form.unit.active" @selected=setActive></toggle>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                     <div class="col-sm-4">
                        <div class="form-group">                           
                            <button type="submit" class="btn btn-success" :disabled="form.errors.any()">確認送出</button>
                             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                             <button class="btn btn-default" @click.prevent="onCanceled">取消</button>  
                         </div>
                    </div>
                    
                </div><!-- </div> end row -->
                    
                
            </form>
           
        </div>
    </div>
    
</template>
<script>
    
    export default {
        name: 'EditUnit',
        props: {
            id: {
              type: Number,
              default: 0
            },
            course_id: {
              type: Number,
              default: 0
            },
        },
        data() {
            return {
                title:Helper.getIcon(Unit.title()),
                loaded:false,
                form: new Form({
                    unit: {
                      
                    }
                }),
                
                selectedUnit:{},

                removedOptions: Helper.boolOptions(),
                activeOptions: Helper.activeOptions(),

                unitOptions:[],
            }
        },
        computed:{
            entityRemoved(){
                if(!this.form.unit) return false
                return Helper.isTrue(this.form.unit.removed)
            }
        },
        beforeMount() {
            this.init()
        },
        methods: {
            init() {
                this.loaded=false
                this.form = new Form({
                    unit: {}
                    
                })
                if(this.id){
                    this.title += '  編輯部門'
                }else{
                    this.title += '  新增部門'
                }
                this.fetchData() 
            },
            fetchData() {
                let getData=null
                if(this.id){
                    getData=Unit.edit(this.id)
                }else{
                    getData=Unit.create()
                }
                getData.then(data=>{
                    let unit=data.unit
                    this.form.unit=data.unit
                    this.unitOptions=data.options

                    let rootOption=Unit.rootOption()
                    this.unitOptions.splice(0, 0, rootOption);

                    if(unit.parentUnit){
                        this.selectedUnit={
                            value:unit.parentUnit.id,
                            text:unit.parentUnit.name
                        }
                    }else{
                         this.selectedUnit=rootOption
                    }

                    this.loaded=true
                }).catch(error=>{
                   Helper.BusEmitError(error)  
                   this.loaded=false
                })  
            },
          
            setActive(val){
                this.form.unit.active=val
            },
            setRemoved(val){
                this.form.unit.removed=val
            },
            clearErrorMsg(name) {
                this.form.errors.clear(name)
            },
            onSubmit() {
                this.form.unit.parent=this.selectedUnit.value
                this.submitForm()
            },
            submitForm() {
                let store=null
                
                if(this.id){
                    store=Unit.update(this.form , this.id)
                }else{
                    store=Unit.store(this.form)
                }
               
                store.then(data => {
                   Helper.BusEmitOK()
                   this.$emit('saved',data)                            
                })
                .catch(error => {
                    Helper.BusEmitError(error) 
                })
            },
            onCanceled(){
                this.$emit('canceled')
            },
            onUnitSelected(item){
                this.selectedUnit=item
            }




        },

    }
</script>