

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

            .gradient-text {
                background: linear-gradient(90deg, #3b82f6, #6366f1);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
            }

        .card {
            
            transition: background-color 0.3s ease;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            position: relative;
            -webkit-transition: opacity 0.5s ease-in-out;
            -moz-transition: opacity 0.5s ease-in-out;
            -ms-transition: opacity 0.5s ease-in-out;
            -o-transition: opacity 0.5s ease-in-out;
            transition: opacity 0.5s ease-in-out;
            opacity: 0.8;
        }

        .card:hover {
            opacity: 1;
        }

        .card-body {
            @apply p-10;
        }
        .card-title {
            @apply flex items-center mb-4;
        }
        .card-title h2 {
            @apply text-lg font-medium text-gray-900;
        }
        </style>
    </head>
    <body class="bg-gray-100 font-sans antialiased">
        
    <?php include './nav.php';
    include './sidebar.php'; 
    // Create sample data for testing
    $users = json_encode([
        ['id' => 1, 'name' => 'User 1'],
        ['id' => 2, 'name' => 'User 2'],
        ['id' => 3, 'name' => 'User 3'],
        ['id' => 4, 'name' => 'User 4'],
        ['id' => 5, 'name' => 'User 5'],
    ]);
    $selected = [1, 3, 4];
    //renderUserSidebar($user, $selected); // Pass the selected user IDs to the sidebar function
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

    $heartRateData = [25, 40, 35, 50, 45, 60, 42];

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

    function calculateWidth($value, $max) {
        $percentage = ($value / $max) * 100;
        return min(100, $percentage); // Ensure we don't exceed 100%
    }
    ?>
    


        

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
            
        </div>
        </main>
        <div class="container mx-auto px-4 py-8">
            

            <!-- Chart Section -->
            <div class="mt-8 bg-white shadow-md rounded-lg p-6">
                <h2 class="text-xl font-semibold mb-4">Activity Overview</h2>
                <canvas id="activityChart"></canvas>
            </div>

            <!-- Activity List Section -->
            <div class="mt-8 bg-white shadow-md rounded-lg p-6">
                <h2 class="text-xl font-semibold mb-4">Recent Activities</h2>
                <ul id="activityList" class="list-disc pl-5"></ul>
            </div>
        </div>

        <script src="/path/to/your/javascript.js"></script> <!-- Include your JavaScript file here -->
        <script>
        lucide.createIcons();
    </script>