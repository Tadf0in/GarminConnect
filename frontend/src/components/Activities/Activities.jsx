import ActivityCard from "./ActivityCard";
import Loading from "../../utils/Loading";
import useFetch from "../../hooks/useFetch";
import useUserData from "../../hooks/useUserData";

export default function Activities () {
    const {userData} = useUserData();
    const {loading, data} = useFetch('/api/activity/?user=' + userData.id, {method: 'GET'});
    
    return (<>
        {loading && <Loading />}

        {data && <main className="max-w-6xl mx-auto px-4 py-6">
            <h1 className="text-4xl font-bold mb-6">Liste des activitiés</h1>
            <br />

            {data.results && data.results.length === 0 ? (
                <p>Aucune activité.</p>
            ) : (
                <div className="grid grid-cols-1 gap-6">
                    {data.results.map((activity, index) => (
                        <ActivityCard key={index} activity={activity} />
                    ))}
                </div>
            )}
        </main>}
    </>);
};