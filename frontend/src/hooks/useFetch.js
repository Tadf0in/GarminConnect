import { useEffect, useState } from "react"

export default function useFetch (url, options) {
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

        }).then(res => res.json()).then(data => {
            setData(data)
        })
        .catch(err => {
            setErrors(err)
        })
        .finally(() => setLoading(false))
    }, [])

    return {
        loading, data, errors
    }
}