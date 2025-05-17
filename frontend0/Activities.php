

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
        <div class="grid grid-cols-1 gap-6">

            <!-- Sleep Card -->
            <div class="card pb-2 pl-1">
                <div class="card-body">
                    <div class="flex justify-between items-center space-x-5 w-full">
                            
                        <div class="flex items-center">
                            <i data-lucide="dumbbell" class="text-indigo-500 mr-1" style="width: 20px; height: 20px;"></i>
                            <h2 class="text-lg font-medium text-gray-900">Strenght</h2>
                        </div>
                        <div class="flex items-center">
                            <i data-lucide="calendar" class="text-indigo-500 mr-2 ml-10" style="width: 20px; height: 20px;"></i>
                            <div class="text-sm font-smaller text-gray-900 ">May 6 2025</div>
                        </div>
                        <div class="flex items-center">
                            <i data-lucide="refresh-ccw-dot" class="text-indigo-500 mr-2 ml-5" style="width: 20px; height: 20px;"></i>
                            <div class="text-sm font-smaller text-gray-900 ">Total sets : 150</div>
                        </div>
                        <div class="flex items-center">
                            <i data-lucide="clock" class="text-indigo-500 mr-2 ml-5" style="width: 20px; height: 20px;"></i>
                            <div class="text-sm font-smaller text-gray-900 ">Time : 1H30</div>
                        </div>
                        <div class="flex items-center">
                            <i data-lucide="heart" class="text-indigo-500 mr-2 ml-5" style="width: 20px; height: 20px;"></i>
                            <div class="text-sm font-smaller text-gray-900 ">Avg Hr : 89bpm</div>
                        </div>
                        <div class="flex items-center">
                            <i data-lucide="heart-crack" class="text-indigo-500 mr-2 ml-5" style="width: 20px; height: 20px;"></i>
                            <div class="text-sm font-smaller text-gray-900 ">Max Hr : 120 bpm</div>
                        </div>
                        <div class="flex items-center">
                            <i data-lucide="zap" class="text-indigo-500 mr-2 ml-5" style="width: 20px; height: 20px;"></i>
                            <div class="text-sm font-smaller text-gray-900 pr-5">Calories : 360</div>
                        </div>
                        
                    </div>
                    
                        
                </div>
                
                    
            </div>
                <!-- <div class="progress-bar"> -->
                        <!-- <div class="progress-fill bg-indigo-500" style="width: <?php echo $data['sleepScore']; ?>%"></div> -->
                    <!-- </div> -->
                


           
            
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