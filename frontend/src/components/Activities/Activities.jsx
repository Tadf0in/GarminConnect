import ActivityCard from "./ActivityCard";
import Loading from "../../utils/Loading";
import useFetch from "../../hooks/useFetch";

export default function Activities () {
    const {loading, data} = useFetch('/api/activity/', {method: 'GET'});
    console.log(data)
    
    return (<>
        {loading && <Loading />}

        { data && <main className="max-w-6xl mx-auto px-4 py-6">
            <h1 class="text-4xl font-bold mb-6">Liste des activitiés</h1>
            <br />

            <div className="grid grid-cols-1 gap-6">
                {data.results && data.results.map((activity, index) => (
                    <ActivityCard key={index} activity={activity} />
                ))}
            </div>
        </main>
        }
    </>);
};