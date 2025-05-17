import React from 'react';

const getBodyBatteryClass = (battery) => {
  if (battery > 80) {
    return 'bg-green-100';
  } else if (battery > 60) {
    return 'bg-yellow-100';
  } else {
    return 'bg-red-100';
  }
};

const BodyBatteryCard = ({ bodyBattery, bodyBatteryCharged, bodyBatteryDrained }) => {
  const batteryClass = getBodyBatteryClass(bodyBattery);

  return (
    <div className="bg-white rounded-xl shadow-md overflow-hidden">
      <div className="p-5">
        <div className="flex items-center mb-4">
          <i
            data-lucide="battery"
            className="text-blue-500 mr-2"
            style={{ width: '20px', height: '20px' }}
          ></i>
          <h2 className="text-lg font-medium text-gray-900">Body Battery</h2>
        </div>
        <div className="flex items-center justify-between mb-3">
          <div className="text-3xl font-bold text-gray-900">{bodyBattery}%</div>
          <div className="flex space-x-4 text-sm">
            <div className="flex items-center">
              <div className="w-3 h-3 bg-green-500 rounded-full mr-1"></div>
              <span className="text-gray-600">+{bodyBatteryCharged} Charged</span>
            </div>
            <div className="flex items-center">
              <div className="w-3 h-3 bg-red-500 rounded-full mr-1"></div>
              <span className="text-gray-600">-{bodyBatteryDrained} Drained</span>
            </div>
          </div>
        </div>
        <div className="w-full bg-gray-200 rounded-full h-2.5 mt-3">
          <div
            className={`h-2.5 rounded-full ${batteryClass}`}
            style={{ width: `${bodyBattery}%` }}
          ></div>
        </div>
      </div>
    </div>
  );
};

export default BodyBatteryCard;
