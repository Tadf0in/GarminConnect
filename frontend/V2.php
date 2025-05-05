<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitTrack - Garmin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/lucide@latest/dist/umd/lucide.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background-color: #f8fafc;
        }
        .card {
            @apply bg-white rounded-2xl shadow-md transition-all duration-300 overflow-hidden hover:shadow-lg;
        }
        .card-body {
            @apply p-6;
        }
        .progress-bar {
            @apply w-full bg-gray-100 rounded-full h-3;
        }
        .progress-fill {
            @apply h-full rounded-full transition-all duration-500;
        }
        .pulse {
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0% {
                opacity: 0.6;
            }
            50% {
                opacity: 1;
            }
            100% {
                opacity: 0.6;
            }
        }
        .sidebar-icon {
            @apply p-3 rounded-xl text-gray-400 hover:text-blue-600 hover:bg-blue-50 transition-all duration-200;
        }
        .sidebar-icon.active {
            @apply text-blue-600 bg-blue-50;
        }
        .gradient-text {
            background: linear-gradient(90deg, #3b82f6, #6366f1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <div class="hidden lg:flex flex-col w-20 bg-white border-r border-gray-100 py-6 items-center">
            <div class="bg-blue-600 rounded-xl w-12 h-12 flex items-center justify-center mb-8">
                <i data-lucide="activity" class="text-white" style="width: 24px; height: 24px;"></i>
            </div>
            
            <div class="flex flex-col space-y-4 items-center flex-1">
                <a href="#" class="sidebar-icon active">
                    <i data-lucide="layout-dashboard" style="width: 22px; height: 22px;"></i>
                </a>
                <a href="#" class="sidebar-icon">
                    <i data-lucide="heart" style="width: 22px; height: 22px;"></i>
                </a>
                <a href="#" class="sidebar-icon">
                    <i data-lucide="activity" style="width: 22px; height: 22px;"></i>
                </a>
                <a href="#" class="sidebar-icon">
                    <i data-lucide="timer" style="width: 22px; height: 22px;"></i>
                </a>
                <a href="#" class="sidebar-icon">
                    <i data-lucide="calendar" style="width: 22px; height: 22px;"></i>
                </a>
                <a href="#" class="sidebar-icon">
                    <i data-lucide="dumbbell" style="width: 22px; height: 22px;"></i>
                </a>
                <a href="#" class="sidebar-icon">
                    <i data-lucide="utensils" style="width: 22px; height: 22px;"></i>
                </a>
                <a href="#" class="sidebar-icon">
                    <i data-lucide="droplets" style="width: 22px; height: 22px;"></i>
                </a>
            </div>
            
            <div class="mt-auto">
                <a href="#" class="sidebar-icon">
                    <i data-lucide="settings" style="width: 22px; height: 22px;"></i>
                </a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 overflow-y-auto flex flex-col">
            <!-- Header -->
            <header class="bg-white shadow-sm sticky top-0 z-10 border-b border-gray-100">
                <div class="px-6 py-4 flex justify-between items-center">
                    <div class="flex items-center">
                        <h1 class="text-2xl font-bold gradient-text mr-6">FitTrack</h1>
                        
                        <nav class="hidden md:flex space-x-6">
                            <a href="#" class="flex items-center py-1 px-1 border-b-2 border-blue-500 text-blue-600 font-medium text-sm">
                                <i data-lucide="layout-dashboard" class="mr-2" style="width: 16px; height: 16px;"></i>
                                Dashboard
                            </a>
                            <a href="#" class="flex items-center py-1 px-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 font-medium text-sm">
                                <i data-lucide="activity" class="mr-2" style="width: 16px; height: 16px;"></i>
                                Activities
                            </a>
                            <a href="#" class="flex items-center py-1 px-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 font-medium text-sm">
                                <i data-lucide="trending-up" class="mr-2" style="width: 16px; height: 16px;"></i>
                                Health Stats
                            </a>
                            <a href="#" class="flex items-center py-1 px-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 font-medium text-sm">
                                <i data-lucide="award" class="mr-2" style="width: 16px; height: 16px;"></i>
                                Goals
                            </a>
                            <a href="#" class="flex items-center py-1 px-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 font-medium text-sm">
                                <i data-lucide="calendar" class="mr-2" style="width: 16px; height: 16px;"></i>
                                Calendar
                            </a>
                        </nav>
                    </div>
                    
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center text-xs text-gray-600 bg-gray-50 rounded-full px-3 py-1.5">
                            <div class="w-2 h-2 bg-green-500 rounded-full mr-2 pulse"></div>
                            <span>Last synced: Today at 7:54 AM</span>
                        </div>
                        <div class="bg-blue-50 text-blue-700 px-3 py-1.5 rounded-full text-xs font-medium flex items-center">
                            <i data-lucide="watch" class="mr-1.5" style="width: 14px; height: 14px;"></i>
                            vívosmart 5
                        </div>
                        <div class="relative">
                            <div class="h-10 w-10 rounded-full bg-gradient-to-r from-blue-500 to-indigo-600 text-white flex items-center justify-center font-medium shadow-md">
                                M
                            </div>
                            <div class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 rounded-full border-2 border-white"></div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Dashboard Content -->
            <main class="flex-1 p-6 bg-gray-50">
                <!-- Summary Row -->
                <div class="grid grid-cols-4 gap-4 mb-6">
                    <div class="card bg-gradient-to-r from-blue-500 to-indigo-600 text-white">
                        <div class="card-body flex items-center">
                            <div class="bg-white/20 rounded-xl p-3 mr-4">
                                <i data-lucide="activity" style="width: 24px; height: 24px;"></i>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-blue-100">Steps Today</div>
                                <div class="text-2xl font-bold">557</div>
                                <div class="text-xs text-blue-100 mt-1">Goal: 10,000</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="card-body flex items-center">
                            <div class="bg-red-50 text-red-500 rounded-xl p-3 mr-4">
                                <i data-lucide="heart" style="width: 24px; height: 24px;"></i>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-500">Heart Rate</div>
                                <div class="text-2xl font-bold text-gray-900">42 <span class="text-sm text-gray-500">bpm</span></div>
                                <div class="text-xs text-gray-500 mt-1">Resting: 44 bpm</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="card-body flex items-center">
                            <div class="bg-green-50 text-green-500 rounded-xl p-3 mr-4">
                                <i data-lucide="battery-full" style="width: 24px; height: 24px;"></i>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-500">Body Battery</div>
                                <div class="text-2xl font-bold text-gray-900">96<span class="text-sm text-gray-500">%</span></div>
                                <div class="text-xs text-gray-500 mt-1">+70 charged | -4 drained</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="card-body flex items-center">
                            <div class="bg-orange-50 text-orange-500 rounded-xl p-3 mr-4">
                                <i data-lucide="flame" style="width: 24px; height: 24px;"></i>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-500">Calories</div>
                                <div class="text-2xl font-bold text-gray-900">686</div>
                                <div class="text-xs text-gray-500 mt-1">Active: 9 | Resting: 677</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Main Cards -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- First Column -->
                    <div class="space-y-6">
                        <!-- Sleep Card -->
                        <div class="card">
                            <div class="card-body">
                                <div class="flex justify-between items-center mb-5">
                                    <div class="flex items-center">
                                        <div class="bg-indigo-50 text-indigo-500 rounded-xl p-2 mr-3">
                                            <i data-lucide="moon" style="width: 20px; height: 20px;"></i>
                                        </div>
                                        <h2 class="text-lg font-medium text-gray-900">Sleep</h2>
                                    </div>
                                    <span class="px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                        Good
                                    </span>
                                </div>
                                
                                <div class="flex justify-between mb-3">
                                    <div>
                                        <div class="text-4xl font-bold text-gray-900">82</div>
                                        <div class="text-sm text-gray-500">Sleep Score</div>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-2xl font-semibold text-gray-900">6h 51m</div>
                                        <div class="text-sm text-gray-500">11:49 PM - 7:00 AM</div>
                                    </div>
                                </div>
                                
                                <div class="progress-bar">
                                    <div class="progress-fill bg-gradient-to-r from-indigo-400 to-indigo-600" style="width: 82%"></div>
                                </div>
                                
                                <div class="mt-5 pt-5 border-t border-gray-100">
                                    <div class="grid grid-cols-4 gap-2 text-center">
                                        <div>
                                            <div class="text-xs text-gray-500">Deep</div>
                                            <div class="text-sm font-medium text-gray-900 mt-1">1h 12m</div>
                                        </div>
                                        <div>
                                            <div class="text-xs text-gray-500">Light</div>
                                            <div class="text-sm font-medium text-gray-900 mt-1">4h 28m</div>
                                        </div>
                                        <div>
                                            <div class="text-xs text-gray-500">REM</div>
                                            <div class="text-sm font-medium text-gray-900 mt-1">1h 11m</div>
                                        </div>
                                        <div>
                                            <div class="text-xs text-gray-500">Awake</div>
                                            <div class="text-sm font-medium text-gray-900 mt-1">0h 0m</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Heart Rate Card -->
                        <div class="card">
                            <div class="card-body">
                                <div class="flex items-center justify-between mb-5">
                                    <div class="flex items-center">
                                        <div class="bg-red-50 text-red-500 rounded-xl p-2 mr-3">
                                            <i data-lucide="heart-pulse" style="width: 20px; height: 20px;"></i>
                                        </div>
                                        <h2 class="text-lg font-medium text-gray-900">Heart Rate</h2>
                                    </div>
                                    <a href="#" class="text-sm text-blue-600 hover:text-blue-800">View Details</a>
                                </div>
                                
                                <div class="flex justify-between items-end mb-5">
                                    <div>
                                        <div class="text-4xl font-bold text-gray-900">42 <span class="text-lg font-normal text-gray-500">bpm</span></div>
                                        <div class="text-sm text-gray-500">Current</div>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-2xl font-semibold text-gray-900">44 <span class="text-sm font-normal text-gray-500">bpm</span></div>
                                        <div class="text-sm text-gray-500">Resting (7d avg)</div>
                                    </div>
                                </div>
                                
                                <div class="relative">
                                    <canvas id="heartRateChart" height="140"></canvas>
                                </div>
                                
                                <div class="mt-4 pt-4 border-t border-gray-100 grid grid-cols-3 gap-2 text-center">
                                    <div>
                                        <div class="text-xs text-gray-500">Min</div>
                                        <div class="text-sm font-medium text-gray-900 mt-1">38 bpm</div>
                                    </div>
                                    <div>
                                        <div class="text-xs text-gray-500">Average</div>
                                        <div class="text-sm font-medium text-gray-900 mt-1">42 bpm</div>
                                    </div>
                                    <div>
                                        <div class="text-xs text-gray-500">Max</div>
                                        <div class="text-sm font-medium text-gray-900 mt-1">78 bpm</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Second Column -->
                    <div class="space-y-6">
                        <!-- Steps Card -->
                        <div class="card">
                            <div class="card-body">
                                <div class="flex items-center justify-between mb-5">
                                    <div class="flex items-center">
                                        <div class="bg-emerald-50 text-emerald-500 rounded-xl p-2 mr-3">
                                            <i data-lucide="footprints" style="width: 20px; height: 20px;"></i>
                                        </div>
                                        <h2 class="text-lg font-medium text-gray-900">Steps</h2>
                                    </div>
                                    <a href="#" class="text-sm text-blue-600 hover:text-blue-800">Weekly Stats</a>
                                </div>
                                
                                <div class="flex justify-between items-end mb-4">
                                    <div>
                                        <div class="text-4xl font-bold text-gray-900">557</div>
                                        <div class="text-sm text-gray-500">Today</div>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-2xl font-semibold text-gray-900">11,610</div>
                                        <div class="text-sm text-gray-500">Weekly Total</div>
                                    </div>
                                </div>
                                
                                <div class="progress-bar">
                                    <div class="progress-fill bg-gradient-to-r from-emerald-400 to-emerald-600" style="width: 5.6%"></div>
                                </div>
                                
                                <div class="mt-3 flex justify-between text-xs text-gray-500">
                                    <span>0</span>
                                    <span>5,000</span>
                                    <span>10,000</span>
                                </div>
                                
                                <div class="mt-6 pt-5 border-t border-gray-100">
                                    <div class="grid grid-cols-7 gap-1">
                                        <div class="text-center">
                                            <div class="text-xs text-gray-500">Mon</div>
                                            <div class="h-24 bg-gray-50 rounded mt-2 flex flex-col justify-end overflow-hidden">
                                                <div class="w-full bg-emerald-200 rounded-b" style="height: 35%"></div>
                                            </div>
                                            <div class="text-xs font-medium mt-1">3,520</div>
                                        </div>
                                        <div class="text-center">
                                            <div class="text-xs text-gray-500">Tue</div>
                                            <div class="h-24 bg-gray-50 rounded mt-2 flex flex-col justify-end overflow-hidden">
                                                <div class="w-full bg-emerald-200 rounded-b" style="height: 45%"></div>
                                            </div>
                                            <div class="text-xs font-medium mt-1">4,503</div>
                                        </div>
                                        <div class="text-center">
                                            <div class="text-xs text-gray-500">Wed</div>
                                            <div class="h-24 bg-gray-50 rounded mt-2 flex flex-col justify-end overflow-hidden">
                                                <div class="w-full bg-emerald-200 rounded-b" style="height: 28%"></div>
                                            </div>
                                            <div class="text-xs font-medium mt-1">2,800</div>
                                        </div>
                                        <div class="text-center">
                                            <div class="text-xs text-gray-500">Thu</div>
                                            <div class="h-24 bg-gray-50 rounded mt-2 flex flex-col justify-end overflow-hidden">
                                                <div class="w-full bg-emerald-200 rounded-b" style="height: 39%"></div>
                                            </div>
                                            <div class="text-xs font-medium mt-1">3,890</div>
                                        </div>
                                        <div class="text-center">
                                            <div class="text-xs text-gray-500">Fri</div>
                                            <div class="h-24 bg-gray-50 rounded mt-2 flex flex-col justify-end overflow-hidden">
                                                <div class="w-full bg-emerald-600 rounded-b" style="height: 87%"></div>
                                            </div>
                                            <div class="text-xs font-medium mt-1">8,720</div>
                                        </div>
                                        <div class="text-center">
                                            <div class="text-xs text-gray-500">Sat</div>
                                            <div class="h-24 bg-gray-50 rounded mt-2 flex flex-col justify-end overflow-hidden">
                                                <div class="w-full bg-emerald-200 rounded-b" style="height: 65%"></div>
                                            </div>
                                            <div class="text-xs font-medium mt-1">6,450</div>
                                        </div>
                                        <div class="text-center">
                                            <div class="text-xs text-gray-500">Sun</div>
                                            <div class="h-24 bg-gray-50 rounded mt-2 flex flex-col justify-end overflow-hidden">
                                                <div class="w-full bg-emerald-200 rounded-b" style="height: 5%"></div>
                                            </div>
                                            <div class="text-xs font-medium mt-1">557</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Calories Card -->
                        <div class="card">
                            <div class="card-body">
                                <div class="flex items-center justify-between mb-5">
                                    <div class="flex items-center">
                                        <div class="bg-orange-50 text-orange-500 rounded-xl p-2 mr-3">
                                            <i data-lucide="flame" style="width: 20px; height: 20px;"></i>
                                        </div>
                                        <h2 class="text-lg font-medium text-gray-900">Calories</h2>
                                    </div>
                                    <a href="#" class="text-sm text-blue-600 hover:text-blue-800">History</a>
                                </div>
                                
                                <div class="flex justify-between items-end mb-4">
                                    <div>
                                        <div class="text-4xl font-bold text-gray-900">686</div>
                                        <div class="text-sm text-gray-500">Total</div>
                                    </div>
                                    <div class="flex space-x-6">
                                        <div>
                                            <div class="text-2xl font-semibold text-gray-900">9</div>
                                            <div class="text-sm text-gray-500">Active</div>
                                        </div>
                                        <div>
                                            <div class="text-2xl font-semibold text-gray-900">677</div>
                                            <div class="text-sm text-gray-500">Resting</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mt-4 h-12 flex rounded-xl overflow-hidden">
                                    <div class="bg-orange-500 h-full" style="width: 1.3%"></div>
                                    <div class="bg-orange-200 h-full flex-1"></div>
                                </div>
                                
                                <div class="mt-2 flex justify-between text-xs">
                                    <span class="text-orange-500 font-medium">Active: 1.3%</span>
                                    <span class="text-orange-400 font-medium">Resting: 98.7%</span>
                                </div>
                                
                                <div class="mt-6 pt-5 border-t border-gray-100">
                                    <h3 class="text-sm font-medium text-gray-900 mb-3">Calorie Breakdown</h3>
                                    <canvas id="caloriesChart" height="180"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Third Column -->
                    <div class="space-y-6">
                        <!-- Body Battery Card -->
                        <div class="card">
                            <div class="card-body">
                                <div class="flex items-center justify-between mb-5">
                                    <div class="flex items-center">
                                        <div class="bg-blue-50 text-blue-500 rounded-xl p-2 mr-3">
                                            <i data-lucide="battery-charging" style="width: 20px; height: 20px;"></i>
                                        </div>
                                        <h2 class="text-lg font-medium text-gray-900">Body Battery</h2>
                                    </div>
                                    <a href="#" class="text-sm text-blue-600 hover:text-blue-800">Details</a>
                                </div>
                                
                                <div class="flex flex-col items-center mb-4">
                                    <div class="relative w-40 h-40 mb-5">
                                        <div class="w-full h-full rounded-full border-8 border-gray-100 flex items-center justify-center">
                                            <div class="text-center">
                                                <div class="text-5xl font-bold text-gray-900">96</div>
                                                <div class="text-sm text-gray-500">Current</div>
                                            </div>
                                        </div>
                                        <svg class="absolute top-0 left-0 w-40 h-40 -rotate-90" viewBox="0 0 120 120">
                                            <circle cx="60" cy="60" r="54" fill="none" stroke="#f0f0f0" stroke-width="12" />
                                            <circle cx="60" cy="60" r="54" fill="none" stroke="url(#blue-gradient)" stroke-width="12" 
                                                stroke-dasharray="339.3" stroke-dashoffset="13.6" />
                                        </svg>
                                        <defs>
                                            <linearGradient id="blue-gradient" x1="0%" y1="0%" x2="100%" y2="0%">
                                                <stop offset="0%" stop-color="#3b82f6" />
                                                <stop offset="100%" stop-color="#60a5fa" />
                                            </linearGradient>
                                        </defs>
                                    </div>
                                    
                                    <div class="grid grid-cols-2 gap-8 w-full">
                                        <div class="flex items-center">
                                            <div class="w-3 h-3 bg-green-500 rounded-full mr-2"></div>
                                            <div>
                                                <div class="text-sm text-gray-500">Charged</div>
                                                <div class="text-xl font-semibold text-gray-900">+70</div>
                                            </div>
                                        </div>
                                        <div class="flex items-center">
                                            <div class="w-3 h-3 bg-red-500 rounded-full mr-2"></div>
                                            <div>
                                                <div class="text-sm text-gray-500">Drained</div>
                                                <div class="text-xl font-semibold text-gray-900">-4</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mt-5 pt-5 border-t border-gray-100">
                                    <canvas id="batteryChart" height="120"></canvas>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Intensity Minutes Card -->
                        <div class="card">
                            <div class="card-body">
                                <div class="flex items-center justify-between mb-5">
                                    <div class="flex items-center">
                                        <div class="bg-purple-50 text-purple-500 rounded-xl p-2 mr-3">
                                            <i data-lucide="zap" style="width: 20px; height: 20px;"></i>
                                        </div>
                                        <h2 class="text-lg font-medium text-gray-900">Intensity Minutes</h2>
                                    </div>
                                    <a href="#" class="text-sm text-blue-600 hover:text-blue-800">View All</a>
                                </div>
                                
                                <div class="flex justify-between items-end mb-4">
                                    <div>
                                        <div class="text-4xl font-bold text-gray-900">75</div>
                                        <div class="text-sm text-gray-500">This Week</div>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-2xl font-semibold text-gray-900">150</div>
                                        <div class="text-sm text-gray-500">Weekly Goal</div>
                                    </div>
                                </div>
                                
                                <div class="progress-bar">
                                    <div class="progress-fill bg-gradient-to-r from-purple-400 to-purple-600" style="width: 50%"></div>
                                </div>
                                
                                <div class="mt-3 flex justify-between text-xs text-gray-500">
                                    <span>0</span>
                                    <span>75</span>
                                    <span>150</span>
                                </div>
                                
                                <div class="mt-6 pt-5 border-t border-gray-100">
                                    <div class="grid grid-cols-7 gap-1">
                                        <div class="text-center">
                                            <div class="text-xs text-gray-500">M</div>
                                            <div class="h-20 bg-gray-50 rounded mt-2 flex flex-col justify-end overflow-hidden">
                                                <div class="w-full bg-purple-200 rounded-b" style="height: 10%"></div>
                                            </div>
                                            <div class="text-xs font-medium mt-1">5</div>
                                        </div>
                                        <div class="text-center">
                                            <div class="text-xs text-gray-500">T</div>
                                            <div class="h-20 bg-gray-50 rounded mt-2 flex flex-col justify-end overflow-hidden">
                                                <div class="w-full bg-purple-200 rounded-b" style="height: 24%"></div>
                                            </div>
                                            <div class="text-xs font-medium mt-1">12</div>
                                        </div>
                                        <div class="text-center">
                                            <div class="text-xs text-gray-500">W</div>
                                            <div class="h-20 bg-gray-50 rounded mt-2 flex flex-col justify-end overflow-hidden">
                                                <div class="w-full bg-purple-200 rounded-b" style="height: 16%"></div>
                                            </div>
                                            <div class="text-xs font-medium mt-1">8</div>
                                        </div>
                                        <div class="text-center">
                                            <div class="text-xs text-gray-500">T</div>
                                            <div class="h-20 bg-gray-50 rounded mt-2 flex flex-col justify-end overflow-hidden">
                                                <div class="w-full bg-purple-200 rounded-b" style="height: 10%"></div>
                                            </div>
                                            <div class="text-xs font-medium mt-1">5</div>
                                        </div>
                                        <div class="text-center">
                                            <div class="text-xs text-gray-500">F</div>
                                            <div class="h-20 bg-gray-50 rounded mt-2 flex flex-col justify-end overflow-hidden">
                                                <div class="w-full bg-purple-600 rounded-b" style="height: 90%"></div>
                                            </div>
                                            <div class="text-xs font-medium mt-1">45</div>
                                        </div>
                                        <div class="text-center">
                                            <div class="text-xs text-gray-500">S</div>
                                            <div class="h-20 bg-gray-50 rounded mt-2 flex flex-col justify-end overflow-hidden">
                                                <div class="w-full bg-purple-200 rounded-b" style="height: 0%"></div>
                                            </div>
                                            <div class="text-xs font-medium mt-1">0</div>
                                        </div>
                                        <div class="text-center">
                                            <div class="text-xs text-gray-500">S</div>
                                            <div class="h-20 bg-gray-50 rounded mt-2 flex flex-col justify-end overflow-hidden">
                                                <div class="w-full bg-purple-200 rounded-b" style="height: 0%"></div>
                                            </div>
                                            <div class="text-xs font-medium mt-1">0</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Footer Row: Quick Stats -->
                <div class="grid grid-cols-5 gap-4 mt-6">
                    <div class="card bg-white p-4 flex items-center">
                        <div class="bg-blue-50 text-blue-500 rounded-lg p-2 mr-3">
                            <i data-lucide="award" style="width: 20px; height: 20px;"></i>
                        </div>
                        <div>
                            <div class="text-xs text-gray-500">Achievements</div>
                            <div class="font-semibold text-gray-900">38 Badges</div>
                        </div>
                    </div>
                    
                    <div class="card bg-white p-4 flex items-center">
                        <div class="bg-green-50 text-green-500 rounded-lg p-2 mr-3">
                            <i data-lucide="trending-up" style="width: 20px; height: 20px;"></i>
                        </div>
                        <div>
                            <div class="text-xs text-gray-500">Floors Climbed</div>
                            <div class="font-semibold text-gray-900">8 Floors</div>
                        </div>
                    </div>
                    
                    <div class="card bg-white p-4 flex items-center">
                        <div class="bg-red-50 text-red-500 rounded-lg p-2 mr-3">
                            <i data-lucide="map-pin" style="width: 20px; height: 20px;"></i>
                        </div>
                        <div>
                            <div class="text-xs text-gray-500">Distance</div>
                            <div class="font-semibold text-gray-900">3.2 mi</div>
                        </div>
                    </div>
                    
                    <div class="card bg-white p-4 flex items-center">
                        <div class="bg-amber-50 text-amber-500 rounded-lg p-2 mr-3">
                            <i data-lucide="droplets" style="width: 20px; height: 20px;"></i>
                        </div>
                        <div>
                            <div class="text-xs text-gray-500">Hydration</div>
                            <div class="font-semibold text-gray-900">2/8 Cups</div>
                        </div>
                    </div>
                    
                    <div class="card bg-white p-4 flex items-center">
                        <div class="bg-violet-50 text-violet-500 rounded-lg p-2 mr-3">
                            <i data-lucide="calendar" style="width: 20px; height: 20px;"></i>
                        </div>
                        <div>
                            <div class="text-xs text-gray-500">Next Event</div>
                            <div class="font-semibold text-gray-900">Run 5K</div>
                        </div>
                    </div>
                </div>
            </main>
            
            <!-- Footer -->
            <footer class="bg-white border-t border-gray-100 mt-auto">
                <div class="px-6 py-4 flex justify-between items-center">
                    <div class="text-sm text-gray-500">© 2025 FitTrack. All rights reserved.</div>
                    <div class="flex items-center space-x-6">
                        <a href="#" class="text-sm text-gray-500 hover:text-blue-600">Privacy Policy</a>
                        <a href="#" class="text-sm text-gray-500 hover:text-blue-600">Terms of Service</a>
                        <a href="#" class="text-sm text-gray-500 hover:text-blue-600">Help Center</a>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    
    <script>
        // Initialize icons
        lucide.createIcons();
        
        // Heart Rate Chart
        const heartRateCtx = document.getElementById('heartRateChart').getContext('2d');
        const heartRateChart = new Chart(heartRateCtx, {
            type: 'line',
            data: {
                labels: ['6AM', '9AM', '12PM', '3PM', '6PM', '9PM', 'Now'],
                datasets: [{
                    label: 'Heart Rate',
                    data: [45, 42, 48, 53, 47, 42, 42],
                    borderColor: '#ef4444',
                    backgroundColor: 'rgba(239, 68, 68, 0.1)',
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#ef4444',
                    pointRadius: 3,
                    pointHoverRadius: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: false,
                        min: 30,
                        max: 80,
                        ticks: {
                            font: {
                                size: 10
                            }
                        },
                        grid: {
                            display: false
                        }
                    },
                    x: {
                        ticks: {
                            font: {
                                size: 10
                            }
                        },
                        grid: {
                            display: false
                        }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index'
                }
            }
        });
        
        // Battery Chart
        const batteryCtx = document.getElementById('batteryChart').getContext('2d');
        const batteryChart = new Chart(batteryCtx, {
            type: 'line',
            data: {
                labels: ['12AM', '3AM', '6AM', '9AM', '12PM', '3PM', '6PM', '9PM', 'Now'],
                datasets: [{
                    label: 'Body Battery',
                    data: [50, 25, 10, 30, 60, 80, 95, 97, 96],
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#3b82f6',
                    pointRadius: 3,
                    pointHoverRadius: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        ticks: {
                            font: {
                                size: 10
                            }
                        },
                        grid: {
                            display: false
                        }
                    },
                    x: {
                        ticks: {
                            font: {
                                size: 10
                            }
                        },
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
        
        // Calories Chart
        const caloriesCtx = document.getElementById('caloriesChart').getContext('2d');
        const caloriesChart = new Chart(caloriesCtx, {
            type: 'doughnut',
            data: {
                labels: ['Active', 'Resting'],
                datasets: [{
                    data: [9, 677],
                    backgroundColor: [
                        '#f97316',
                        '#fdba74'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: 12,
                            padding: 15,
                            font: {
                                size: 11
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>