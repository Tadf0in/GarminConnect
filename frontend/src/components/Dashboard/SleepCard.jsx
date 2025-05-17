import React from 'react';

// Fonction pour déterminer les classes de style en fonction du score de sommeil
const getSleepScoreClass = (score) => {
  if (score > 80) {
    return {
      bg: 'bg-green-100',
      text: 'text-green-800',
      label: 'Good'
    };
  } else if (score > 60) {
    return {
      bg: 'bg-yellow-100',
      text: 'text-yellow-800',
      label: 'Fair'
    };
  } else {
    return {
      bg: 'bg-red-100',
      text: 'text-red-800',
      label: 'Poor'
    };
  }
};

const SleepCard = ({ sleepScore, sleepDuration, sleepTime }) => {
  const sleepClass = getSleepScoreClass(sleepScore);

  return (
    <div className="bg-white rounded-xl shadow-md overflow-hidden">
      <div className="p-5">
        <div className="flex justify-between items-center mb-4">
          <div className="flex items-center">
            <i
              data-lucide="clock"
              className="text-indigo-500 mr-2"
              style={{ width: '20px', height: '20px' }}
            ></i>
            <h2 className="text-lg font-medium text-gray-900">Sleep</h2>
          </div>
          <span
            className={`px-3 py-1 rounded-full text-sm font-medium ${sleepClass.bg} ${sleepClass.text}`}
          >
            {sleepClass.label}
          </span>
        </div>
        <div className="flex justify-between mb-2">
          <div className="text-3xl font-bold text-gray-900">{sleepScore}</div>
          <div className="text-right">
            <div className="text-xl font-semibold text-gray-900">{sleepDuration}</div>
            <div className="text-sm text-gray-500">{sleepTime}</div>
          </div>
        </div>
        <div className="w-full bg-gray-200 rounded-full h-2.5 mt-3">
          <div
            className="h-2.5 rounded-full bg-indigo-500"
            style={{ width: `${sleepScore}%` }}
          ></div>
        </div>
      </div>
    </div>
  );
};

export default SleepCard;