import React from 'react';

const StepsCard = ({ steps, currentSteps, goal }) => {

  // Fonction pour calculer la progression
  const calculateWidth = (currentSteps, dailyGoal) => {
    return (currentSteps / dailyGoal) * 100;
  };

  return (
    <div className="bg-white rounded-xl shadow-md overflow-hidden">
      <div className="p-5">
        <div className="flex items-center mb-4">
          <i
            data-lucide="activity"
            className="text-emerald-500 mr-2"
            style={{ width: '20px', height: '20px' }}
          ></i>
          <h2 className="text-lg font-medium text-gray-900">Steps</h2>
        </div>
        <div className="flex justify-between items-end">
          <div>
            <div className="text-3xl font-bold text-gray-900">
              {currentSteps.toLocaleString()} {/* Formatage des chiffres */}
            </div>
            <div className="text-sm text-gray-500">Today</div>
          </div>
          <div className="text-right">
            <div className="text-xl font-semibold text-gray-900">
              {steps.toLocaleString()} {/* Formatage des chiffres */}
            </div>
            <div className="text-sm text-gray-500">Weekly Goal: {goal}/day</div>
          </div>
        </div>        
        <div className="w-full bg-gray-200 rounded-full h-2.5 mt-3">
          <div
            className="h-2.5 rounded-full bg-emerald-500"
            style={{ width: `${calculateWidth(currentSteps, goal)}%` }}
          ></div>
        </div>
        <div className="mt-3 flex justify-between text-xs text-gray-500">
          <span>0</span>
          <span>5,000</span>
          <span>10,000</span>
        </div>
      </div>
    </div>
  );
};

export default StepsCard;
