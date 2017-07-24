class Department {
    constructor(data) {

        for (let property in data) {
            this[property] = data[property];
        }

        this.parent=''
        if(data.parentDepartment){
            this.parent=data.parentDepartment.name
        }

     

    }
    static title() {
        return 'Departments'
    }
    static source() {
        return '/departments'
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
    static index() {
        let url = this.source()
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
    static create(courseId, userId) {
        let url = this.createUrl()
        url += '?course=' + courseId
        if (userId) {
            url += '&user_id=' + userId
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

    
    static getThead(canSelect) {
        let thead = [{
            title: '姓名',
            key: 'fullname',
            sort: false,
            static: true,
            default: true

        }, {
            title: '報名日期',
            key: 'date',
            sort: true,
            static: true,
            default: true

        }, {
            title: '狀態',
            key: 'status',
            sort: true,
            static: true,
            default: true

        }, {
            title: '課程名稱',
            key: 'course',
            sort: false,
            static: true,
            default: true

        }, {
            title: '課程費用',
            key: 'tuition',
            sort: true,
            default: true
        }, {
            title: '折扣',
            key: 'discount',
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


export default Department;