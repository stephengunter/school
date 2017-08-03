class Staff {
    constructor(data) {
       
        for (let property in data) {
            this[property] = data[property];
        }
       

    }
    static title(){
       return 'Staffs'
    }
    static source(){
        return '/staffs'
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
    static updatePhoto(staffId, photoId) {
        let form = new Form({
            photo_id: photoId
        })
        let url ='/staffs/' + staffId + '/update-photo'
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
    static activeText(status) {
       
        if (status==1) return '在職中'
        else if (status==0) return '留職停薪'
         else if (status==-1) return '已離職'
        return ''
    }
    static activeLabel(status) {
        status=Number(status)
        let style='label label-default'
        if (status>0) style= 'label label-info'
         let text=this.activeText(status)

        return `<span class="${style}" > ${text} </span>`
    }
    
    

    static getThead(canSelect){
      let thead=  [{
                        title: '姓名',
                        key: 'name',
                        sort: false,
                        default:true
                    },{
                        title: '員工編號',
                        key: 'number',
                        sort: true,
                        default:true
                    },{
                        title: '部門',
                        key: 'unit_id',
                        sort: false,
                        default:true
                    },{
                        title: '狀態',
                        key: 'status',
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


export default Staff;