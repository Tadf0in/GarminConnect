import { useEffect } from "react";
import { createIcons, icons } from 'lucide';

import BodyBatteryCard from './BodyBatteryCard';
import CaloriesCard from './CaloriesCard';
import HeartRateCard from './HeartRateCard';
import IntensityMinutesCard from './IntensityMinutesCard';
import SleepCard from './SleepCard';
import StepsCard from './StepsCard';

import { dashboardData } from '../../data/dashboardData';

export default function Dashboard () {
    if (localStorage.getItem('user_data') == null) window.location.href = "/login";

    let data = dashboardData;

    useEffect(() => {
        createIcons({ icons });
    }, [])

    return (
    <main class="max-w-6xl mx-auto px-4 py-6">
        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6" role="alert">
            <p class="font-bold">Information</p>
            <p>
                Nous nous sommes fait bannir de l'API Garmin après avoir envoyé trop de requêtes, nous n'avons pas eu le temps de récolter les informations générales déstinées au tableau de bord.
                <br />
                Les données que vous voyées ici sont des données fictives.
                <br />
                Seul la page <a href="/activities" style={{textDecoration: "underline"}}>Activities</a> contient de vraies donénes.
            </p>
        </div>

        <h1 class="text-4xl font-bold mb-6">Tableau de bord</h1>
        <br />
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <SleepCard
                sleepScore={data.sleepScore}
                sleepDuration={data.sleepDuration}
                sleepTime={data.sleepTime}
            />
            <BodyBatteryCard
                bodyBattery={data.bodyBattery}
                bodyBatteryCharged={data.bodyBatteryCharged}
                bodyBatteryDrained={data.bodyBatteryDrained}
            />
            <HeartRateCard
                heartRate={data.heartRate}
                restingHeartRate={data.restingHeartRate}
            />
            <StepsCard
                steps={data.steps}
                currentSteps={data.currentSteps}
                goal={data.goalSteps}
            />
            <CaloriesCard
                caloriesBurned={data.caloriesBurned}
                activeCalories={data.activeCalories}
                restingCalories={data.restingCalories}
            />
            <IntensityMinutesCard 
                intensityMinutes={data.intensityMinutes}
                intensityMinutesGoal={data.intensityMinutesGoal}
            />
        </div>
    </main>
    );
};