class Unit {
    constructor(data) {

        for (let property in data) {
            this[property] = data[property];
        }

        this.parent=''
        if(data.parentUnit){
            this.parent=data.parentUnit.name
        }

     

    }
    static title() {
        return 'Units'
    }
    static source() {
        return '/units'
    }
    static createUrl() {
        return this.source() + '/create'
    }
    static storeUrl() {
        return this.source()
    }
    static showUrl(id) {
        return this.source() + '/' + id
    }
    static editUrl(id) {
        return this.showUrl(id) + '/edit'
    }
    static updateUrl(id) {
        return this.showUrl(id)
    }
    static deleteUrl(id) {
        return this.source() + '/' + id
    }
    static index(removed,parent) {
        let url = this.source()
        if(Helper.isTrue(removed)){
            url += '?removed=1'
        }else{
              url += '?parent=' + parent
        }
        return new Promise((resolve, reject) => {
            axios.get(url)
                .then(response => {
                    resolve(response.data)
                })
                .catch(error => {
                    reject(error);
                })

        })
    }
    static tree() {
        let url = this.source() + '?mode=tree'
        return new Promise((resolve, reject) => {
            axios.get(url)
                .then(response => {
                    resolve(response.data)
                })
                .catch(error => {
                    reject(error);
                })

        })
    }
    static create() {
        let url = this.createUrl()
        
        return new Promise((resolve, reject) => {
            axios.get(url)
                .then(response => {
                    resolve(response.data)
                })
                .catch(error => {
                    reject(error);
                })

        })
    }
    static store(form) {
        let url = this.storeUrl()
        let method = 'post'
        return new Promise((resolve, reject) => {
            form.submit(method, url)
                .then(data => {
                    resolve(data);
                })
                .catch(error => {
                    reject(error);
                })
        })
    }
    static show(id) {
        return new Promise((resolve, reject) => {
            let url = this.showUrl(id)
            axios.get(url)
                .then(response => {
                    resolve(response.data)
                })
                .catch(error => {
                    reject(error);
                })

        })
    }
    static edit(id) {
        let url = this.editUrl(id)
        return new Promise((resolve, reject) => {

            axios.get(url)
                .then(response => {
                    resolve(response.data)
                })
                .catch(error => {
                    reject(error);
                })

        })
    }
    static update(form, id) {
        let url = this.updateUrl(id)
        let method = 'put'
        return new Promise((resolve, reject) => {
            form.submit(method, url)
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
            let url = this.deleteUrl(id)
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
    static options() {
        return new Promise((resolve, reject) => {
            let url = this.source() + '/options'
            axios.get(url)
                .then(response => {
                    resolve(response.data)
                })
                .catch(error => {
                    reject(error);
                })

        })
    }
    static rootOption(){
        return {
            text:' ----- ',
            value: 0,
        }
    }

    
    static getThead(canSelect) {
        let thead = [{
            title: '名稱',
            key: 'name',
            sort: false,
            static: true,
            default: true

        }, {
            title: '代碼',
            key: 'code',
            sort: true,
            static: true,
            default: true

        }, {
            title: '狀態',
            key: 'active',
            sort: true,
            static: true,
            default: true

        }, {
            title: '顯示順序',
            key: 'order',
            sort: false,
            default:true
         },{
            title: '最後更新',
            key: 'updated_by',
            sort: true,
            default: true
        }]

        if (canSelect) {
            let selectColumn = {
                title: '',
                key: '',
                sort: false,
                static: true,
                default: true
            }
            thead.splice(0, 0, selectColumn);
        }


        return thead
    }
  


    








}


export default Unit;