import React from 'react';

const HeartRateCard = ({ heartRate, restingHeartRate }) => {
  return (
    <div className="bg-white rounded-xl shadow-md overflow-hidden">
      <div className="p-5">
        <div className="flex items-center mb-4">
          <i
            data-lucide="heart"
            className="text-red-500 mr-2"
            style={{ width: '20px', height: '20px' }}
          ></i>
          <h2 className="text-lg font-medium text-gray-900">Heart Rate</h2>
        </div>
        <div className="flex justify-between items-end">
          <div>
            <div className="text-3xl font-bold text-gray-900">
              {heartRate} <span className="text-lg font-normal text-gray-500">bpm</span>
            </div>
            <div className="text-sm text-gray-500">Current</div>
          </div>
          <div className="text-right">
            <div className="text-xl font-semibold text-gray-900">
              {restingHeartRate} <span className="text-sm font-normal text-gray-500">bpm</span>
            </div>
            <div className="text-sm text-gray-500">Resting (7d avg)</div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default HeartRateCard;
