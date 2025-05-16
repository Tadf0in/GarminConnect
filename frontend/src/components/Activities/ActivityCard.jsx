import { useEffect } from "react";
import { createIcons, icons } from 'lucide';

export default function ActivityCard({ activity }) {
    function ActivityCardStat({ icon, text }) {
        useEffect(() => {
            createIcons({ icons });
        }, [])

        return <div className="flex items-center">
            <i data-lucide={icon} className="text-indigo-500 mr-2 ml-5" style={{ width: '20px', height: '20px' }}></i>
            <div className="text-sm font-smaller text-gray-900">{text}</div>
        </div>
    }

    const logos = {
        "strength_training": "dumbbell",
        "running": "plane-landing",
        "walking": "footprints",
    }


    function formatDuration(duration) {
        const [hours, minutes, seconds] = duration.split(':');
        const formattedSeconds = seconds.split('.')[0]; // Remove milliseconds
        return `${hours}h${minutes}m${formattedSeconds}s`;
    }

    return (
        <div className="card bg-white pb-2 pl-1 rounded-lg shadow-md opacity-80 hover:opacity-100 transition-opacity duration-300">
            <div className="card-body">
                <div className="flex justify-between items-center space-x-5 w-full flex-wrap">
                    <ActivityCardStat icon={logos[activity.type.name]} text={activity.name} />
                    <ActivityCardStat icon="calendar" text={new Date(activity.start).toDateString()} />
                    <ActivityCardStat icon="clock" text={`Time : ${formatDuration(activity.duration)}`} />
                    <ActivityCardStat icon="heart" text={`Avg Hr : ${activity.averageHR} bpm`} />
                    <ActivityCardStat icon="heart-crack" text={`Max Hr : ${activity.maxHR} bpm`} />
                    <ActivityCardStat icon="zap" text={`Calories : ${activity.calories}`} />
                </div>
            </div>
        </div>
    );
}