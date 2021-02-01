import Errors from './Errors';

class Form {
    /**
     * Create a new Form instance.
     *
     * @param {object} data
     */
    constructor(data) {
        this.originalData = data;

        for (let field in data) {
            this[field] = data[field];
        }

        this.errors = new Errors();
    }

    /**
     * Fetch all relevant data for the form.
     */
    data() {
        let data = {};

        for (let property in this.originalData) {
            data[property] = this[property];
        }

        return data;
    }

    append(field, val) {
        //formData.append('file', this.file);
        this.data[field] = val;
    }


    /**
     * Reset the form fields.
     */
    reset() {
        for (let field in this.originalData) {
            this[field] = '';
        }

        this.errors.clear();
    }


    /**
     * Send a POST request to the given URL.
     * .
     * @param {string} url
     */
    post(url, fd) {
        return this.submit('post', url, fd);
    }


    /**
     * Send a PUT request to the given URL.
     * .
     * @param {string} url
     * @param fd
     */
    put(url, fd) {
        return this.submit('put', url, fd);
    }


    /**
     * Send a PATCH request to the given URL.
     * .
     * @param {string} url
     */
    patch(url) {
        return this.submit('patch', url);
    }


    /**
     * Send a DELETE request to the given URL.
     * .
     * @param {string} url
     */
    delete(url) {
        return this.submit('delete', url);
    }


    /**
     * Submit the form.
     *
     * @param {string} requestType
     * @param {string} url
     * @param fd
     */
    submit(requestType, url, fd) {
        axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        axios.defaults.headers.post['Content-Type'] = 'multipart/form-data';

        if (requestType === 'put') {

            if (typeof fd === 'undefined') {
                fd = new FormData();
            }

            for (let property in this.originalData) {
                if (property == null) {
                    //
                } else if (typeof this[property] === 'object' && this[property] !== null) {
                    fd.append(property, JSON.stringify(this[property]));
                } else if (this[property] === undefined || this[property] === null || this[property] === "null") {
                    //fd.append(property, null);
                } else if (this[property] === "true" || this[property] === true) {
                    fd.append(property, true);
                } else if (this[property] === "false" || this[property] === false) {
                    //fd.append(property, false);
                } else {
                    fd.append(property, this[property]);
                }
                //console.log(property, this[property]);
            }
            //console.log('fd appended for put request', fd);
            fd.append("_method", "PATCH");
            //console.log('fd method PATCH added', fd);

            return new Promise((resolve, reject) => {
                axios.post(url, fd)
                    .then(response => {
                        this.onSuccess(response.data);

                        resolve(response.data);
                    })
                    .catch(error => {
                        this.onFail(error.response.data.errors);

                        reject(error.response.data.errors);
                    });
            });


            /*return new Promise((resolve, reject) => {
                axios.fetch(url, {
                    method: 'PATCH',
                    headers: {
                        'Content-type': 'application/x-www-form-urlencoded'
                    },
                    body: fd
                })
                    .then(response => {
                        this.onSuccess(response.data);

                        resolve(response.data);
                    })
                    .catch(error => {
                        this.onFail(error.response.data.errors);

                        reject(error.response.data.errors);
                    });
            });*/


        } else {

            if (typeof fd !== 'undefined') {
                //console.log('fd is not undefined', fd);
                for (let property in this.originalData) {
                    fd.append(property, this[property]);
                    //console.log(property, this[property]);
                }
            } else {
                //console.log('fd is undefined', fd)
                fd = this.data();
            }

            return new Promise((resolve, reject) => {
                axios[requestType](url, fd)
                    .then(response => {
                        this.onSuccess(response.data);

                        resolve(response.data);
                    })
                    .catch(error => {
                        this.onFail(error.response.data.errors);

                        reject(error.response.data.errors);
                    });
            });
        }
    }


    /**
     * Handle a successful form submission.
     *
     * @param {object} data
     */
    onSuccess(data) {
        this.reset();
    }


    /**
     * Handle a failed form submission.
     *
     * @param {object} errors
     */
    onFail(errors) {
        this.errors.record(errors);
    }
}

export default Form;
