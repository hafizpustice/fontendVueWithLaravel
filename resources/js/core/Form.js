import Error from './Error'
class Form {
    constructor(data) {
        this.orginalData = data;

        console.log(this.orginalData);
        for (let field in data) {
            this[field] = data[field];
        }

        this.errors = new Error();
    }


    data() {
        let data = {};

        for (let property in this.orginalData) {
            data[property] = this[property];
        }
        // let data = Object.assign({}, this); //{name,description,origianlData,errors}
        // delete data.orginalData;
        // delete data.errors;
        return data;
    }
    get(url) {
        return this.submit('get', url)
    }

    post(url) {
        return this.submit('post', url)
    }

    put(url) {
        return this.submit('put')
    }

    submit(requestType, url) {

        return new Promise((resolve, reject) => {

            axios[requestType](url, this.data())
                .then(response => {
                    console.log('start')
                    console.log(response.data)
                    this.onSuccess(response.data);
                    resolve(response.data);
                })
                .catch(error => {
                    this.onFail(error.response);
                    reject(error.response);
                })
        });

    }

    onSuccess(response) {
        //alert(response.message);
        // this.errors.clear();
        this.reset();
    }
    onFail(errors) {
        console.log(errors.data)
            // console.log(error.response.data.errors);
        this.errors.record(errors.data.errors);
    }

    reset() {
        console.log('reset');
        console.log(this.orginalData);
        for (let field in this.orginalData) {
            console.log('reset field ' + field);
            this[field] = '';
        }
    }
    fill(data) {
        for (let field in this.orginalData) {
            console.log('set field ' + field);
            this[field] = data[field];
        }
    }
}

export default Form;