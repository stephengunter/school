class Student {
    constructor(data) {
       
        for (let property in data) {
            this[property] = data[property];
        }
       

    }
    static title(){
       return 'Students'
    }
    static source(){
        return '/students'
    }
    static createUrl(){
         return this.source() + '/create' 
    }
    static storeUrl(){
         return this.source()
    }
    static showUrl(id){
         return this.source() + '/' + id
    }
    static editUrl(id){
         return this.showUrl(id) +  '/edit'
    }
    static updateUrl(id){
        return this.showUrl(id)
    }
    static deleteUrl(id){
         return this.source() + '/' + id
    }
    static create(){
        let url = this.createUrl() 
      
        return new Promise((resolve, reject) => {
            axios.get(url)
                .then(response => {
                   resolve(response.data)
                })
                .catch(error=> {
                     reject(error)
                })
           
        })
    }
    static store(form){
        let url =this.storeUrl() 
        let method='post'
        return new Promise((resolve, reject) => {
            form.submit(method,url)
                .then(data => {
                    resolve(data);
                })
                .catch(error => {
                    reject(error);
                })
        })
    }
    static import(form){
        let url =this.storeUrl() + '/import'
        let method='post'
        return new Promise((resolve, reject) => {
            form.submit(method,url)
                .then(data => {
                    resolve(data);
                })
                .catch(error => {
                    reject(error);
                })
        })
    }
    static show(id){
        return new Promise((resolve, reject) => {
            let url = this.showUrl(id) 
            axios.get(url)
                .then(response => {
                   resolve(response.data)
                })
                .catch(error=> {
                     reject(error);
                })
           
        })
    }
    static edit(id){
        let url = this.editUrl(id) 
        return new Promise((resolve, reject) => {
            axios.get(url)
                .then(response => {
                   resolve(response.data)
                })
                .catch(error=> {
                     reject(error);
                })
           
        })
    }
    static update(form , id){
         let url =this.updateUrl(id) 
         let method='put'
        return new Promise((resolve, reject) => {
            form.submit(method,url)
                .then(data => {
                    resolve(data);
                })
                .catch(error => {
                    reject(error);
                })
        })
    }
    static delete(id) {
        return new Promise((resolve, reject) => {
            let url =this.deleteUrl(id) 
            let form = new Form()
            form.delete(url)
                .then(response => {
                    resolve(true);
                })
                .catch(error => {
                    reject(error);
                })
        })
    }
    static updatePhoto(studentId, photoId) {
        let form = new Form({
            photo_id: photoId
        })
        let url ='/students/' + studentId + '/update-photo'
        let method = 'put'
        return new Promise((resolve, reject) => {
            form.submit(method,url)
                .then(saved => {
                    resolve(saved);
                })
                .catch(error => {
                    reject(error);
                })
        })
       
    }
    static indexOptions(params){
        let url =this.source() + '/index-options' 
        url=Helper.buildQuery(url,params)
        return new Promise((resolve, reject) => {
                     axios.get(url)
                    .then(response => {
                        resolve(response.data);
                    })
                    .catch(error => {
                        reject(error);
                    })
                })  
    }
    static activeText(active) {
        if (parseInt(active)) return '在學中'
        return '非在學'
    }
    static activeLabel(active) {
        let style='label label-default'
        if (parseInt(active)) style= 'label label-info'
         let text=this.activeText(active)

        return `<span class="${style}" > ${text} </span>`
    }
    
    

    static getThead(canSelect){
      let thead=  [{
                        title: '姓名',
                        key: 'name',
                        sort: false,
                        default:true
                    },{
                        title: '學號',
                        key: 'number',
                        sort: true,
                        default:true
                    },{
                        title: '科系',
                        key: 'department_id',
                        sort: false,
                        default:true
                    }, {
                        title: '班級',
                        key: 'class_id',
                        sort: false,
                        default:true
                    },{
                        title: '狀態',
                        key: 'active',
                        sort: false,
                        default:true
                    }, {
                        title: '更新時間',
                        key: 'updated_at',
                        sort: true,
                        default:true
                    }]
                if(canSelect){
                   let selectColumn={
                    title: '',
                    key: '',
                    sort: false,
                    static:true,
                    default:true
                   }
                   thead.splice(0, 0, selectColumn);
                }
            return thead
    }
    
    
   
    

}


export default Student;