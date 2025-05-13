import BodyBatteryCard from './BodyBatteryCard';
import CaloriesCard from './CaloriesCard';
import HeartRateCard from './HeartRateCard';
import SleepCard from './SleepCard';
import StepsCard from './StepsCard';

import { dashboardData } from '../../data/dashboardData';
import IntensityMinutesCard from './IntensityMinutesCard';

export default function Dashboard () {
    let data = dashboardData;

    return (
    <main class="max-w-6xl mx-auto px-4 py-6">
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