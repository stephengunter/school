class Classes {
    constructor(data) {
       
        for (let property in data) {
            this[property] = data[property];
        }
       

    }
    static title(){
       return 'Classes'
    }
    static source(){
        return '/classes'
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
    static trash(){
        let url = this.source() 
        url += '?removed=1'
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
    static indexOptions(department_id){
        let url = this.source() + '/index-options'
        url += '?department=' + department_id
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
    static options(department_id){
        let url = this.source() + '/options'
        url += '?department=' + department_id
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
    static index(params){
        let url = this.source() 
        url =Helper.buildQuery(url,params)
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
    static create(department_id){
        let url = this.createUrl() 
        url += '?department=' + department_id
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
    static updateDisplayOrder(id,up){
        let url =this.updateUrl(id) + '/update-order'
        let method='put'
        let form = new Form({                        
                         up: up
                    })
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
    
    

    static getThead(canSelect){
      let thead=  [{
                        title: '名稱',
                        key: 'name',
                        sort: false,
                        static:true,
                        default:true
                    },{
                        title: '狀態',
                        key: 'active',
                        sort: false,
                        static:true,
                        default:true
                    }, {
                        title: '順序',
                        key: 'order',
                        sort: false,
                        static:false,
                        default:true
                    },{
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
    
    
    static gradeOptions(){
        return Helper.numberOptions(1,5)
    }
    

}


export default Classes;