class TPDepartment {
    constructor(data) {

        for (let property in data) {
            this[property] = data[property];
        }

       
    }
    
    static source() {
        return '/tp-departments'
    }
    
    static storeUrl() {
        return this.source()
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
    
    static store(department_ids) {
        let form=new Form({
                   department_ids:department_ids
               })
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
    
  


    








}


export default TPDepartment;