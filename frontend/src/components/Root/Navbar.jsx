import '../../css/navbar.css';

import { NavLink } from 'react-router';
import { useEffect } from 'react';
import { createIcons, icons } from 'lucide';
// import logo from '../../assets/logo.png';

export default function Navbar() {
    useEffect(() => {
        createIcons({ icons });
    }, [])

    return (
        <header className="bg-white shadow-sm sticky top-0 z-10 border-b border-gray-100">
            <div className="px-6 py-4 flex justify-between items-center">
                <div className="flex items-center">
                    <div className="bg-blue-600 rounded-full w-8 h-8 flex items-center justify-center">
                        <i data-lucide="activity" className="text-white" style={{ width: '18px', height: '18px' }}></i>
                    </div>
                    <a href="#" className="text-2xl font-bold gradient-text mr-6">&nbsp;FitTrack</a>

                    <nav className="hidden md:flex space-x-6">
                        <NavItem href="/dashboard" icon="layout-dashboard" label="Dashboard" active />
                        <NavItem href="/activities" icon="activity" label="Activities" />
                        <NavItem href="/health" icon="trending-up" label="Health Stats" />
                    </nav>
                </div>

                <div className="flex items-center space-x-5">
                    <SyncStatus time="Today at 7:54 AM" />
                    <DeviceStatus device="vívosmart 5" />
                    <UserAvatar letter="M" />
                </div>
            </div>
        </header>
    );
};

const NavItem = ({ href, icon, label, active }) => (
  <NavLink to={href} className={`flex items-center py-1 px-1 border-b-2 ${active ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'} font-medium text-sm`}>
    <i data-lucide={icon} className="mr-2" style={{ width: '16px', height: '16px' }}></i>
    {label}
  </NavLink>
);

const SyncStatus = ({ time }) => (
  <div className="flex items-center text-xs text-gray-600 bg-gray-50 rounded-full px-3 py-1.5">
    <div className="w-2 h-2 bg-green-500 rounded-full mr-2 pulse"></div>
    <span>Last synced: {time}</span>
  </div>
);

const DeviceStatus = ({ device }) => (
  <div className="bg-blue-50 text-blue-700 px-3 py-1.5 rounded-full text-xs font-medium flex items-center">
    <i data-lucide="watch" className="mr-1.5" style={{ width: '14px', height: '14px' }}></i>
    {device}
  </div>
);

const UserAvatar = ({ letter }) => (
  <div className="relative">
    <div className="h-10 w-10 rounded-full bg-gradient-to-r from-blue-500 to-indigo-600 text-white flex items-center justify-center font-medium shadow-md">
      {letter}
    </div>
    <div className="absolute bottom-0 right-0 w-3 h-3 bg-green-500 rounded-full border-2 border-white"></div>
  </div>
);
