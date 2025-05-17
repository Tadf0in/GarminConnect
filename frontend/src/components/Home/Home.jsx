import useFetch from '../../hooks/useFetch'
import Loading from '../../utils/Loading'

export default function Home() {
    const {loading, data} = useFetch('/api/user/', {method: 'GET'})

    return <>
        {loading && <Loading />}

        { data ? 'data' : 'no'}
    </>
}