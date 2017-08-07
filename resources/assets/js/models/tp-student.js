class TPStudent {
    constructor(data) {

        for (let property in data) {
            this[property] = data[property];
        }

       
    }
    
    static source() {
        return '/tp-students'
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
    
    static store(student_ids) {
        let form=new Form({
                   student_ids:student_ids
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


export default TPStudent;