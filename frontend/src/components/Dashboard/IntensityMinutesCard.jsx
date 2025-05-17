import React from 'react';

const IntensityMinutesCard = ({ intensityMinutes, intensityMinutesGoal }) => {
  const calculateWidth = (part, total) => {
    return (part / total) * 100;
  };

  const getRandomHeight = (index) => {
    return index === 4 ? 75 : Math.floor(Math.random() * 40) + 5;
  };

  const weekDays = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];

  return (
    <div className="card">
      <div className="card-body">
        <div className="flex items-center mb-4">
          <i
            data-lucide="trending-up"
            className="text-purple-500 mr-2"
            style={{ width: '20px', height: '20px' }}
          ></i>
          <h2 className="text-lg font-medium text-gray-900">Intensity Minutes</h2>
        </div>
        <div className="text-3xl font-bold text-gray-900 mb-2">
          {intensityMinutes}
        </div>
        <div className="progress-bar">
          <div
            className="progress-fill bg-purple-500"
            style={{ width: `${calculateWidth(intensityMinutes, 150)}%` }}
          ></div>
        </div>
        <div className="mt-3 flex justify-between text-xs text-gray-500">
          <span>0</span>
          <span>75</span>
          <span>150 weekly goal</span>
        </div>
        <div className="mt-4 grid grid-cols-7 gap-1">
          {weekDays.map((day, index) => (
            <div key={index} className="text-center">
              <div className="text-xs text-gray-500">{day}</div>
              <div className="h-16 bg-gray-100 rounded mt-1 flex flex-col justify-end">
                <div
                  className={`w-full ${index === 4 ? 'bg-purple-500' : 'bg-purple-200'} rounded-b`}
                  style={{ height: `${getRandomHeight(index)}%` }}
                ></div>
              </div>
            </div>
          ))}
        </div>
      </div>
    </div>
  );
};

export default IntensityMinutesCard;
