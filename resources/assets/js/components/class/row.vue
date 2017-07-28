<template>
   
    <tr v-if="readOnly">
        <td>
          {{ entity.grade.name }}
        </td>
        <td>
          {{ entity.name }}
        </td>
        
        
        <td v-if="removed" v-html="$options.filters.removedLabel(entity.removed)" ></td>
        <td v-else v-html="$options.filters.activeLabel(entity.active)" ></td>
        
        <td v-if="!removed">
          <button @click="displayUp(entity.id)" class="btn btn-default btn-xs">
            <span class="glyphicon glyphicon-arrow-up" aria-hidden="true"></span>
          </button>
          <button @click="displayDown(entity.id)" class="btn btn-default btn-xs">
            <span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span>
          </button>
        </td>
        <td>
          <updated :entity="entity"></updated>
        </td>
        <td>
           <button v-show="entity.canEdit"  class="btn btn-primary btn-xs" 
              @click.prevent="beginEdit">
              <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
          </button>  
           <button v-if="entity.canDelete"  class="btn btn-danger btn-xs"
              @click.prevent="btnDeleteClicked">
               <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
          </button>
        </td>
    </tr>  
    <tr v-else>
       <td v-if="loaded">
          <select  v-model="form.entity.grade_id" class="form-control">
             <option v-for="item in gradeOptions" :value="item.value" v-text="item.text"></option>
          </select>
       </td>
       <td v-if="loaded">
          <input type="text" name="entity.name" @keydown="clearErrorMsg('entity.name')" class="form-control" v-model="form.entity.name">
          <small class="text-danger" v-if="form.errors.has('entity.name')" v-text="form.errors.get('entity.name')"></small>
       </td>
       
       <td v-if="loaded">
           <div  v-if="removed">
               <input type="hidden" v-model="form.entity.removed"  >
               <toggle :items="removedOptions"   :default_val="form.entity.removed" @selected=setRemoved></toggle>
           </div> 
       </td>
       <td>&nbsp;</td>
       <td v-if="!removed">&nbsp;</td>
       <td v-if="loaded">
          <button @click.prevent="onSubmit"  class="btn btn-success btn-xs">
            <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>
          </button>  
          <button  class="btn btn-default btn-xs" @click.prevent="cancelEdit">
             <span aria-hidden="true" class="glyphicon glyphicon-refresh"></span>
          </button>
       </td>
    </tr>
</template>

<script>
   
    export default {
        name: 'ClassRow',
        props:{
            entity:{
              type:Object,
              default:{}
            },
            removed:{
              type:Boolean,
              default:false
            },
        },
        data() {
            return {
                readOnly:true,

                loaded:false,
                form:{},
                gradeOptions:[],
                removedOptions: Helper.removedOptions(),
            }
        },
        beforeMount() {
           this.init();
        },
        methods: {
            getId(){
                if(this.entity) return Helper.tryParseInt(this.entity.id)
                return 0
            },            
            init(){  
                let id=this.getId()
                this.readOnly = id > 0

                if(!this.readOnly) {
                    this.form=new Form({
                        entity: this.entity
                    }) 
                    this.gradeOptions=this.entity.gradeOptions
                    this.loaded=true
                }
                          
            },
            fetchData(){
                
                let id=this.getId()
                let getData=Classes.edit(id)
                getData.then(data => {
                    let entity = data.entity
                    
                    this.form=new Form({
                        entity: entity
                    }) 

                    this.gradeOptions=entity.gradeOptions
                    this.loaded=true
                    
                })
                .catch(error=> {
                    Helper.BusEmitError(error)
                })
            },
            beginEdit(){
              
                this.loaded=false
                this.readOnly=false
                this.fetchData()
            },
            cancelEdit(){
                let id=this.getId()
                if(id){
                   this.readOnly=true
                }else{
                    this.$emit('canceled')
                }
               
            },
            btnDeleteClicked(){
                let values={
                    id:this.getId(),
                    name:this.entity.name
                }
                this.$emit('btn-delete-clicked' , values)
            },
            clearErrorMsg(name) {
                this.form.errors.clear(name)
            },
            setRemoved(val){
                this.form.entity.removed=val
            },
            onSubmit() {
                this.submitForm()
            },
            submitForm() {
                let save = null
                let id=Number(this.form.entity.id)
                if(id > 0){
                    save=Classes.update(this.form, id)
                }else{
                    save=Classes.store(this.form)
                }
             
                save.then(result => {
                   Helper.BusEmitOK()
                   this.readOnly=true;
                  
                   this.$emit('saved')
                })
                .catch(error => {
                    Helper.BusEmitError(error,'存檔失敗')
                })
            },
            displayUp(id){
                this.$emit('order-up',id)
            },
            displayDown(id){
               this.$emit('order-down',id)
            },
            
          
            
          
        }, 
    }
</script>
