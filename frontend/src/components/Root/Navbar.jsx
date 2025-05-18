import '../../css/navbar.css';

import { NavLink } from 'react-router';
import { useState, useEffect } from 'react';
import { createIcons, icons } from 'lucide';

import useUserData from '../../hooks/useUserData';

export default function Navbar() {
    const [profileMenuOpen, setProfileMenuOpen] = useState(false);

    useEffect(() => {
        createIcons({ icons });
    }, []);

    const { allUserData, userData, userDataIndex, setUserDataIndex } = useUserData();

    return (
      <header className="bg-white shadow-sm sticky top-0 z-10 border-b border-gray-100">
        <div className="px-6 py-4 flex justify-between items-center">
          <div className="flex items-center">
            <div className="bg-blue-600 rounded-full w-8 h-8 flex items-center justify-center">
              <i data-lucide="activity" className="text-white" style={{ width: '18px', height: '18px' }}></i>
            </div>
            <NavLink to="/" className="text-2xl font-bold gradient-text mr-6">&nbsp;FitTrack</NavLink>

            
            {userData && (
              // On affiche le menu que si on est connecté
                <nav className="hidden md:flex space-x-6">
                <NavItem href="/dashboard" icon="layout-dashboard" label="Dashboard" active={window.location.pathname === '/dashboard'}/>
                <NavItem href="/activities" icon="activity" label="Activities" active={window.location.pathname === '/activities'}/>
                <NavItem href="/health" icon="trending-up" label="Health Stats" active={window.location.pathname === '/health'}/>
                </nav>
              )}
              </div>

              <div className="flex items-center space-x-5">
              {userData ? (
                <>
                <button
                  onClick={async () => {
                    try {
                      const response = await fetch('http://localhost:8000/api/refresh-profile/' + userData.profiles[0].id + '/', { 
                        method: 'POST',
                        headers: {
                          Authorization: 'Bearer ' + localStorage.getItem('access_token')
                        }
                      });
                      if (response.ok) {
                        window.location.reload();
                      } else {
                        console.error('Failed to refresh profile');
                      }
                    } catch (error) {
                      console.error('Error refreshing profile:', error);
                    }
                  }}
                  className="flex items-center text-blue-600 hover:text-blue-800"
                  style={{ cursor: 'pointer' }}
                >
                  <i data-lucide="refresh-cw" className="mr-2" style={{ width: '16px', height: '16px' }}></i>
                </button>

                <div className="flex items-center text-xs text-gray-600 bg-gray-50 rounded-full px-3 py-1.5">
                  <div className="w-2 h-2 bg-green-500 rounded-full mr-2 pulse"></div>
                  <span>Last synced: {userData.profiles && userData.profiles.length > 0 ? new Date(userData.profiles[0].last_update).toLocaleString() : 'Jamais'}</span>
                </div>

                <div className="bg-blue-50 text-blue-700 px-3 py-1.5 rounded-full text-xs font-medium flex items-center">
                  <i data-lucide="watch" className="mr-1.5" style={{ width: '14px', height: '14px' }}></i>
                  {userData.profiles && userData.profiles.length > 0 ? userData.profiles[0].brand : 'Aucune montre connectée'}
                </div>
                
                <div className="relative">
                  <button
                    onClick={() => setProfileMenuOpen(!profileMenuOpen)}
                    className="h-10 w-10 rounded-full bg-gradient-to-r from-blue-500 to-indigo-600 text-white flex items-center justify-center font-medium shadow-md focus:outline-none"
                  >
                    {userData.first_name[0]}
                  </button>
                  <div className="absolute bottom-0 right-0 w-3 h-3 bg-green-500 rounded-full border-2 border-white"></div>

                  {profileMenuOpen && (
                    <div className="absolute right-0 mt-2 w-64 bg-white border border-gray-200 rounded-md shadow-lg z-50">
                      <ul className="divide-y divide-gray-100 max-h-64 overflow-y-auto">
                        { allUserData  && allUserData.map((profile, index) => {
                          const isActive = userData.id == profile.id;
                          return <li
                            key={index}
                            onClick={() => {
                              localStorage.setItem('user_data_index', index);
                              setUserDataIndex(index);
                              setProfileMenuOpen(false);
                              window.location.replace('');
                            }}
                            className={`flex items-center px-4 py-2 cursor-pointer text-sm hover:bg-gray-100 ${
                              isActive ? 'bg-blue-50 font-semibold text-blue-700' : ''
                            }`}
                          >
                            {/* Avatar rond avec initiale */}
                            <div
                              className={`h-8 w-8 rounded-full flex items-center justify-center mr-3 font-medium text-white ${
                                isActive ? 'bg-blue-600' : 'bg-gray-400'
                              }`}
                            >
                              {profile.first_name[0]}
                            </div>

                            {/* Nom  */}
                            <div className="flex-grow">
                              {profile.first_name} {profile.last_name}
                            </div>

                            {/* Check si actif */}
                            {isActive && (
                              <i
                                data-lucide="check"
                                className="text-blue-600"
                                style={{ width: '16px', height: '16px' }}
                              ></i>
                            )}
                          </li>
                        })}
                      </ul>
                    </div>
                  )}
                </div>

                <button
                  onClick={() => {
                    localStorage.clear();
                    window.location.href = '/login';
                  }}
                  className="flex items-center text-red-600 hover:text-red-800"
                  style={{cursor: 'pointer'}}
                >
                  <i data-lucide="log-out" className="mr-2" style={{ width: '16px', height: '16px'}}></i>
                  Logout
                </button>
              </>
            ) : (
              // Sinon un bouton pour se connecter
              <NavLink to="/login" className="flex items-center text-blue-600 hover:text-blue-800" style={{cursor: 'pointer'}}>
                <i data-lucide="log-in" className="mr-2" style={{ width: '16px', height: '16px' }}></i>
                Login
              </NavLink>
            )}
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