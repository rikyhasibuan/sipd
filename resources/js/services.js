/*jshint esversion: 8 */
import axios from 'axios';

export default {
    async fetchData(actionUrl) {
        let data = await axios.get(`${actionUrl}`).then(response => { return response; });
        return data.data;
    },
    async postData(actionUrl, payload) {
        let data = await axios.post(`${actionUrl}`, payload)
        .then((response) => { 
            return response; 
        });
        return data.data;
    },
    async postUploadData(actionUrl, payload) {
        let data = await axios.post(`${actionUrl}`, payload, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        }).then((response) => {
            return response;
        });
        return data.data;
    },
    async putData(actionUrl, payload) {
        let data = await axios.put(`${actionUrl}`, payload)
            .then((response) => {
                return response;
            });
        return data.data;
    },
    async deleteData(actionUrl) {
        let data = await axios.delete(`${actionUrl}`).then(response => {
            return response;
        });
        return data.data;
    }
};