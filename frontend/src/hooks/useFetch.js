import { useEffect, useState } from "react"

export default function useFetch (url, options, deps=[]) {
    const [loading, setLoading] = useState(true);
    const [data, setData] = useState(null);
    const [errors, setErrors] = useState(null);

    const API_URL = 'http://localhost:8000';

    useEffect(() => {
        fetch(API_URL + url, {
            ...options,
            headers: {
                ...options.headers,
                'Accept': 'application/json; charset=UTF-8',
                ...(localStorage.getItem('access_token') && { 'Authorization': `Bearer ${localStorage.getItem('access_token')}` })
            }

        }).then(async res => {
            // Si le token a expiré
            if (res.status === 401) { 
                return res.json().then(json => {
                    if (json.code === 'token_not_valid') {
                        alert('Veuillez vous reconnecter')
                        localStorage.clear();
                        window.location.href = '/login';
                        return Promise.reject('Unauthorized');
                    }
                    return Promise.reject(json);
                });
            }
            return res.json();
        }).then(data => {
            setData(data)
        })
        .catch(err => {
            setErrors(err)
        })
        .finally(() => setLoading(false))
    }, [url, ...deps])

    return {
        loading, data, errors
    }
}