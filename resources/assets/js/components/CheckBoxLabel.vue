<template>
      <div class="checkbox">
          <label style="font-size: 1.2em">
            <!-- <input data-name="護理系" id="SelectedDepartments_29" name="SelectedDepartments" type="checkbox" value="29" checked> -->

           <input :data-name="option.text"   type="checkbox" 
           :value="option.value" :checked="selected"
           @click="selectedChange">
          
            <span class="cr">
               <i class="cr-icon fa fa-check"></i>
            </span>{{ option.text }}
          </label>
      </div>

</template>

<script>
    export default {
      props: {
          option: {
             type: Object,
             default: {}
          },
      },
      name: 'CheckBoxLabel',
      data() {
          return {
              selected: false,
          }
      },
      watch: {
          option: {
            handler: function () {
               this.init()
            },
            deep: true
          },
           
      },
      beforeMount() {
          this.init()
      },
      methods:{
          init(){
             this.selected=Helper.isTrue(this.option.selected)
          },
          selectedChange(){
              this.selected = !this.selected
              if(this.selected){
                  this.$emit('selected',this.option)
              }else{
                  this.$emit('unselected',this.option)
              }
          }
      }
      
      
    }
</script>

<style scoped>
.checkbox label:after, 
.radio label:after {
    content: '';
    display: table;
    clear: both;
}

.checkbox .cr,
.radio .cr {
    position: relative;
    display: inline-block;
    border: 1px solid #a9a9a9;
    border-radius: .25em;
    width: 1.3em;
    height: 1.3em;
    float: left;
    margin-right: .5em;
}

.radio .cr {
    border-radius: 50%;
}

.checkbox .cr .cr-icon,
.radio .cr .cr-icon {
    position: absolute;
    font-size: .8em;
    line-height: 0;
    top: 50%;
    left: 20%;
}

.radio .cr .cr-icon {
    margin-left: 0.04em;
}

.checkbox label input[type="checkbox"],
.radio label input[type="radio"] {
    display: none;
}

.checkbox label input[type="checkbox"] + .cr > .cr-icon,
.radio label input[type="radio"] + .cr > .cr-icon {
    transform: scale(3) rotateZ(-20deg);
    opacity: 0;
    transition: all .3s ease-in;
}

.checkbox label input[type="checkbox"]:checked + .cr > .cr-icon,
.radio label input[type="radio"]:checked + .cr > .cr-icon {
    transform: scale(1) rotateZ(0deg);
    opacity: 1;
}

.checkbox label input[type="checkbox"]:disabled + .cr,
.radio label input[type="radio"]:disabled + .cr {
    opacity: .5;
}
</style>