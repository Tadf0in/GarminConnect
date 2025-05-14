import { useEffect, useState } from "react";
import { createIcons, icons } from 'lucide';
import ActivityCard from "./ActivityCard";

export default function Activities () {
    const [activity, setActivity] = useState(null);
    
    useEffect(() => {
        createIcons({ icons });
    }, [])


    useEffect(() => {
        // Simuler une activité ou utiliser une API
        setActivity({
        name: "Strength",
        start: "2025-05-06T07:00:00Z",
        totalSets: 150,
        duration: "1H30",
        averageHR: 89,
        maxHR: 120,
        calories: 360,
        });
    }, []);

    return (
    <main className="max-w-6xl mx-auto px-4 py-6">
        <h1 class="text-4xl font-bold mb-6">Liste des activitiés</h1>
        <br />

        <div className="grid grid-cols-1 gap-6">
            <div className="card bg-white pb-2 pl-1 rounded-lg shadow-md opacity-80 hover:opacity-100 transition-opacity duration-300">
                <div className="card-body">
                    <div className="flex justify-between items-center space-x-5 w-full flex-wrap">
                        <ActivityCard icon="dumbbell" text={activity?.name || "Strength"} />
                        <ActivityCard icon="calendar" text={new Date(activity?.start).toDateString()} />
                        <ActivityCard icon="refresh-ccw-dot" text={`Total sets : ${activity?.totalSets || 150}`} />
                        <ActivityCard icon="clock" text={`Time : ${activity?.duration || "1H30"}`} />
                        <ActivityCard icon="heart" text={`Avg Hr : ${activity?.averageHR || 89} bpm`} />
                        <ActivityCard icon="heart-crack" text={`Max Hr : ${activity?.maxHR || 120} bpm`} />
                        <ActivityCard icon="zap" text={`Calories : ${activity?.calories || 360}`} />
                    </div>
                </div>
            </div>
        </div>
    </main>
    );
};