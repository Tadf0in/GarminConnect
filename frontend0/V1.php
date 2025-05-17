<?php
// garmin-dashboard.php

// Sample data based on the provided Garmin Connect screenshot
$data = [
    'sleepScore' => 82,
    'sleepDuration' => "6h 51m",
    'sleepTime' => "11:49 PM - 7:00 AM",
    'bodyBattery' => 96,
    'bodyBatteryCharged' => 70,
    'bodyBatteryDrained' => 4,
    'heartRate' => 42,
    'restingHeartRate' => 44,
    'intensityMinutes' => 75,
    'steps' => 11610,
    'currentSteps' => 557,
    'caloriesBurned' => 686,
    'activeCalories' => 9,
    'restingCalories' => 677,
    'lastSynced' => "Today at 7:54 AM",
    'device' => "vívosmart 5"
];

// Helper function to calculate percentage width for progress bars
function calculateWidth($value, $max) {
    $percentage = ($value / $max) * 100;
    return min(100, $percentage); // Ensure we don't exceed 100%
}

// Function to get class for sleep score
function getSleepScoreClass($score) {
    if ($score > 80) {
        return [
            'bg' => 'bg-green-100',
            'text' => 'text-green-800',
            'label' => 'Good'
        ];
    } elseif ($score > 60) {
        return [
            'bg' => 'bg-yellow-100',
            'text' => 'text-yellow-800',
            'label' => 'Fair'
        ];
    } else {
        return [
            'bg' => 'bg-red-100',
            'text' => 'text-red-800',
            'label' => 'Poor'
        ];
    }
}

$sleepClass = getSleepScoreClass($data['sleepScore']);

// Navigation tabs
$tabs = [
    ['id' => 'dashboard', 'name' => 'Dashboard', 'icon' => 'bar-chart'],
    ['id' => 'activities', 'name' => 'Activities', 'icon' => 'activity'],
    ['id' => 'stats', 'name' => 'Health Stats', 'icon' => 'trending-up'],
    ['id' => 'goals', 'name' => 'Goals', 'icon' => 'award'],
    ['id' => 'calendar', 'name' => 'Calendar', 'icon' => 'calendar-days'],
];

// Active tab
$activeTab = isset($_GET['tab']) ? $_GET['tab'] : 'dashboard';

// Heart rate sample data for chart
$heartRateData = [25, 40, 35, 50, 45, 60, 42];

// Week days for intensity minutes chart
$weekDays = ['M', 'T', 'W', 'T', 'F', 'S', 'S'];

// Include Tailwind CSS via CDN
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitTrack - Garmin Dashboard</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        /* Additional custom styles if needed */
        .card {
            @apply bg-white rounded-xl shadow-sm overflow-hidden;
        }
        .card-body {
            @apply p-5;
        }
        .card-title {
            @apply flex items-center mb-4;
        }
        .card-title h2 {
            @apply text-lg font-medium text-gray-900;
        }
        .progress-bar {
            @apply w-full bg-gray-200 rounded-full h-2.5 mt-3;
        }
        .progress-fill {
            @apply h-2.5 rounded-full;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Header -->
    <header class="bg-white shadow-sm">
        <div class="max-w-6xl mx-auto px-4 py-4 flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <div class="bg-blue-600 rounded-full w-8 h-8 flex items-center justify-center">
                    <i data-lucide="activity" class="text-white" style="width: 18px; height: 18px;"></i>
                </div>
                <h1 class="text-xl font-semibold text-gray-900">FitTrack</h1>
            </div>
            <div class="flex items-center space-x-4">
                <div class="flex items-center text-sm text-gray-600">
                    <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                    <span>Last synced: <?php echo $data['lastSynced']; ?></span>
                </div>
                <div class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-medium">
                    <?php echo $data['device']; ?>
                </div>
                <div class="h-8 w-8 rounded-full bg-blue-500 text-white flex items-center justify-center font-medium">
                    M
                </div>
            </div>
        </div>
    </header>

    <!-- Navigation -->
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-6xl mx-auto">
            <nav class="flex space-x-8 px-4" aria-label="Tabs">
                <?php foreach ($tabs as $tab): ?>
                    <a href="?tab=<?php echo $tab['id']; ?>" 
                       class="flex items-center py-4 px-1 border-b-2 font-medium text-sm 
                       <?php echo ($activeTab === $tab['id']) 
                           ? 'border-blue-500 text-blue-600' 
                           : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'; ?>">
                        <i data-lucide="<?php echo $tab['icon']; ?>" class="mr-2" style="width: 16px; height: 16px;"></i>
                        <?php echo $tab['name']; ?>
                    </a>
                <?php endforeach; ?>
            </nav>
        </div>
    </div>

    <!-- Main Content -->
    <main class="max-w-6xl mx-auto px-4 py-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Sleep Card -->
            <div class="card">
                <div class="card-body">
                    <div class="flex justify-between items-center mb-4">
                        <div class="flex items-center">
                            <i data-lucide="clock" class="text-indigo-500 mr-2" style="width: 20px; height: 20px;"></i>
                            <h2 class="text-lg font-medium text-gray-900">Sleep</h2>
                        </div>
                        <span class="px-3 py-1 rounded-full text-sm font-medium <?php echo $sleepClass['bg'] . ' ' . $sleepClass['text']; ?>">
                            <?php echo $sleepClass['label']; ?>
                        </span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <div class="text-3xl font-bold text-gray-900"><?php echo $data['sleepScore']; ?></div>
                        <div class="text-right">
                            <div class="text-xl font-semibold text-gray-900"><?php echo $data['sleepDuration']; ?></div>
                            <div class="text-sm text-gray-500"><?php echo $data['sleepTime']; ?></div>
                        </div>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill bg-indigo-500" style="width: <?php echo $data['sleepScore']; ?>%"></div>
                    </div>
                </div>
            </div>

            <!-- Body Battery Card -->
            <div class="card">
                <div class="card-body">
                    <div class="flex items-center mb-4">
                        <i data-lucide="battery" class="text-blue-500 mr-2" style="width: 20px; height: 20px;"></i>
                        <h2 class="text-lg font-medium text-gray-900">Body Battery</h2>
                    </div>
                    <div class="flex items-center justify-between mb-3">
                        <div class="text-3xl font-bold text-gray-900"><?php echo $data['bodyBattery']; ?></div>
                        <div class="flex space-x-4 text-sm">
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-green-500 rounded-full mr-1"></div>
                                <span class="text-gray-600">+<?php echo $data['bodyBatteryCharged']; ?> Charged</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-red-500 rounded-full mr-1"></div>
                                <span class="text-gray-600">-<?php echo $data['bodyBatteryDrained']; ?> Drained</span>
                            </div>
                        </div>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill bg-blue-500" style="width: <?php echo $data['bodyBattery']; ?>%"></div>
                    </div>
                </div>
            </div>

            <!-- Heart Rate Card -->
            <div class="card">
                <div class="card-body">
                    <div class="flex items-center mb-4">
                        <i data-lucide="heart" class="text-red-500 mr-2" style="width: 20px; height: 20px;"></i>
                        <h2 class="text-lg font-medium text-gray-900">Heart Rate</h2>
                    </div>
                    <div class="flex justify-between items-end">
                        <div>
                            <div class="text-3xl font-bold text-gray-900"><?php echo $data['heartRate']; ?> <span class="text-lg font-normal text-gray-500">bpm</span></div>
                            <div class="text-sm text-gray-500">Current</div>
                        </div>
                        <div class="text-right">
                            <div class="text-xl font-semibold text-gray-900"><?php echo $data['restingHeartRate']; ?> <span class="text-sm font-normal text-gray-500">bpm</span></div>
                            <div class="text-sm text-gray-500">Resting (7d avg)</div>
                        </div>
                    </div>
                    <div class="mt-4 h-16 flex items-end">
                        <?php foreach ($heartRateData as $value): ?>
                            <div class="flex-1 mx-0.5">
                                <div class="bg-red-400 rounded-t" style="height: <?php echo $value; ?>%"></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- Steps Card -->
            <div class="card">
                <div class="card-body">
                    <div class="flex items-center mb-4">
                        <i data-lucide="activity" class="text-emerald-500 mr-2" style="width: 20px; height: 20px;"></i>
                        <h2 class="text-lg font-medium text-gray-900">Steps</h2>
                    </div>
                    <div class="flex justify-between items-end">
                        <div>
                            <div class="text-3xl font-bold text-gray-900"><?php echo number_format($data['currentSteps']); ?></div>
                            <div class="text-sm text-gray-500">Today</div>
                        </div>
                        <div class="text-right">
                            <div class="text-xl font-semibold text-gray-900"><?php echo number_format($data['steps']); ?></div>
                            <div class="text-sm text-gray-500">Weekly Goal: 10,000/day</div>
                        </div>
                    </div>
                    <div class="progress-bar mt-4">
                        <div class="progress-fill bg-emerald-500" style="width: <?php echo calculateWidth($data['currentSteps'], 10000); ?>%"></div>
                    </div>
                    <div class="mt-3 flex justify-between text-xs text-gray-500">
                        <span>0</span>
                        <span>5,000</span>
                        <span>10,000</span>
                    </div>
                </div>
            </div>

            <!-- Calories Card -->
            <div class="card">
                <div class="card-body">
                    <div class="flex items-center mb-4">
                        <i data-lucide="zap" class="text-orange-500 mr-2" style="width: 20px; height: 20px;"></i>
                        <h2 class="text-lg font-medium text-gray-900">Calories</h2>
                    </div>
                    <div class="flex justify-between">
                        <div>
                            <div class="text-3xl font-bold text-gray-900"><?php echo $data['caloriesBurned']; ?></div>
                            <div class="text-sm text-gray-500">Total</div>
                        </div>
                        <div class="flex space-x-6">
                            <div>
                                <div class="text-xl font-semibold text-gray-900"><?php echo $data['activeCalories']; ?></div>
                                <div class="text-sm text-gray-500">Active</div>
                            </div>
                            <div>
                                <div class="text-xl font-semibold text-gray-900"><?php echo $data['restingCalories']; ?></div>
                                <div class="text-sm text-gray-500">Resting</div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 flex h-10">
                        <div class="bg-orange-400 h-full rounded-l" style="width: <?php echo calculateWidth($data['activeCalories'], $data['caloriesBurned']); ?>%"></div>
                        <div class="bg-orange-200 h-full rounded-r flex-1"></div>
                    </div>
                </div>
            </div>

            <!-- Intensity Minutes Card -->
            <div class="card">
                <div class="card-body">
                    <div class="flex items-center mb-4">
                        <i data-lucide="trending-up" class="text-purple-500 mr-2" style="width: 20px; height: 20px;"></i>
                        <h2 class="text-lg font-medium text-gray-900">Intensity Minutes</h2>
                    </div>
                    <div class="text-3xl font-bold text-gray-900 mb-2"><?php echo $data['intensityMinutes']; ?></div>
                    <div class="progress-bar">
                        <div class="progress-fill bg-purple-500" style="width: <?php echo calculateWidth($data['intensityMinutes'], 150); ?>%"></div>
                    </div>
                    <div class="mt-3 flex justify-between text-xs text-gray-500">
                        <span>0</span>
                        <span>75</span>
                        <span>150 weekly goal</span>
                    </div>
                    <div class="mt-4 grid grid-cols-7 gap-1">
                        <?php foreach ($weekDays as $index => $day): ?>
                            <div class="text-center">
                                <div class="text-xs text-gray-500"><?php echo $day; ?></div>
                                <div class="h-16 bg-gray-100 rounded mt-1 flex flex-col justify-end">
                                    <?php 
                                    // Set the height for the current day (Friday) to match intensity minutes, others random
                                    $height = ($index === 4) ? 75 : rand(5, 40);
                                    $bgColor = ($index === 4) ? 'bg-purple-500' : 'bg-purple-200';
                                    ?>
                                    <div class="w-full <?php echo $bgColor; ?> rounded-b" style="height: <?php echo $height; ?>%"></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Initialize Lucide Icons -->
    <script>
        lucide.createIcons();
    </script>
</body>
</html>