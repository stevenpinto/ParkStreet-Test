import axios from "axios";
import { useEffect, useState } from "react";
import { trackPromise } from "react-promise-tracker";

export function useClientOptions() {
    const [clients, setClients] = useState([]);

    useEffect(() => {
        trackPromise(
            axios.post('http://localhost:8000/clients/')
                .then(function (response) {
                    if (response.data) {
                        setClients(response.data);
                    }
                })
                .catch(function (error) {
                    console.log(error);
                })
        )

    }, []);

    return clients;

}

export function useInvoiceList(productId, clientId, relativeDate) {
    const [items, setItems] = useState([]);

    useEffect(() => {

        trackPromise(
            axios.post('http://localhost:8000/', {
                'product_id': productId,
                'client_id': clientId,
                'relative_date': relativeDate
            })
                .then(function (response) {
                    if (response.data) {
                        setItems(response.data);
                    }
                })
                .catch(function (error) {
                    console.log(error);
                })
       );
}, [productId, clientId, relativeDate]);

return items;
}