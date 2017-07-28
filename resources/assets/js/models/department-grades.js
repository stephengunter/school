class DepartmentGrades {
    constructor(data) {
        for (let property in data) {
            this[property] = data[property];
        }
    }
    static source(){
        return '/department-grades'
    }
    static storeUrl(){
         return this.source()
    }
    static editUrl(id) {
        return this.source() + '/' + id + '/edit'
    }
    static index(department_id){
        let url = this.source() 
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
    
    

    
    
    
    
    

}


export default DepartmentGrades;