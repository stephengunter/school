<template>
   
    <tr v-if="readOnly">
        <td>
          {{ grade.name }}
        </td>
        
        
        <td v-if="removed" v-html="$options.filters.removedLabel(grade.removed)" ></td>
       
        <td v-if="!removed">
          <button @click="displayUp(grade.id)" class="btn btn-default btn-xs">
            <span class="glyphicon glyphicon-arrow-up" aria-hidden="true"></span>
          </button>
          <button @click="displayDown(grade.id)" class="btn btn-default btn-xs">
            <span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span>
          </button>
        </td>
        <td>
          <updated :entity="grade"></updated>
        </td>
        <td>
           <button v-show="grade.canEdit"  class="btn btn-primary btn-xs" 
              @click.prevent="beginEdit">
              <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
          </button>  
           <button v-if="grade.canDelete"  class="btn btn-danger btn-xs"
              @click.prevent="btnDeleteClicked">
               <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
          </button>
        </td>
    </tr>  
    <tr v-else>
       <td v-if="loaded">
          <input type="text" name="grade.name" @keydown="clearErrorMsg('grade.name')" class="form-control" v-model="form.grade.name">
          <small class="text-danger" v-if="form.errors.has('grade.name')" v-text="form.errors.get('grade.name')"></small>
       </td>
       
       <td v-if="loaded">
           <div  v-if="removed">
               <input type="hidden" v-model="form.grade.removed"  >
               <toggle :items="removedOptions"   :default_val="form.grade.removed" @selected=setRemoved></toggle>
           </div> 
       </td>
       
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
            grade:{
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
                removedOptions: Helper.removedOptions(),
            }
        },
        beforeMount() {
           this.init();
        },
        methods: {
            getId(){
                if(this.grade) return Helper.tryParseInt(this.grade.id)
                return 0
            },            
            init(){  
                let id=this.getId()
                this.readOnly = id > 0

                if(!this.readOnly) {
                    this.form=new Form({
                        grade: this.grade
                    }) 

                    this.loaded=true
                }
                          
            },
            fetchData(){
                
                let id=this.getId()
                let getData=Grade.edit(id)
                getData.then(data => {
                    let grade = data.grade
                    
                    this.form=new Form({
                        grade: grade
                    }) 
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
                    name:this.grade.name
                }
                this.$emit('btn-delete-clicked' , values)
            },
            clearErrorMsg(name) {
                this.form.errors.clear(name)
            },
            setRemoved(val){
                this.form.grade.removed=val
            },
            onSubmit() {
                this.submitForm()
            },
            submitForm() {
                let save = null
                let id=Number(this.form.grade.id)
                if(id > 0){
                    save=Grade.update(this.form, id)
                }else{
                    save=Grade.store(this.form)
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
