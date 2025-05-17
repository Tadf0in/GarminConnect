import React from 'react';

const CaloriesCard = ({ caloriesBurned, activeCalories, restingCalories }) => {
  const calculateWidth = (part, total) => {
    return (part / total) * 100;
  };

  return (
    <div className="card">
      <div className="card-body">
        <div className="flex items-center mb-4">
          <i
            data-lucide="zap"
            className="text-orange-500 mr-2"
            style={{ width: '20px', height: '20px' }}
          ></i>
          <h2 className="text-lg font-medium text-gray-900">Calories</h2>
        </div>
        <div className="flex justify-between">
          <div>
            <div className="text-3xl font-bold text-gray-900">{caloriesBurned}</div>
            <div className="text-sm text-gray-500">Total</div>
          </div>
          <div className="flex space-x-6">
            <div>
              <div className="text-xl font-semibold text-gray-900">{activeCalories}</div>
              <div className="text-sm text-gray-500">Active</div>
            </div>
            <div>
              <div className="text-xl font-semibold text-gray-900">{restingCalories}</div>
              <div className="text-sm text-gray-500">Resting</div>
            </div>
          </div>
        </div>
        <div className="mt-4 flex h-10">
          <div
            className="bg-orange-400 h-full rounded-l"
            style={{ width: `${calculateWidth(activeCalories, caloriesBurned)}%` }}
          ></div>
          <div className="bg-orange-200 h-full rounded-r flex-1"></div>
        </div>
      </div>
    </div>
  );
};

export default CaloriesCard;
