<?php echo '

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
        </style>
    </head>

    <div class="flex-1 overflow-y-auto flex flex-col">
                <!-- Header -->
                <header class="bg-white shadow-sm sticky top-0 z-10 border-b border-gray-100">
                    <div class="px-6 py-4 flex justify-between items-center">
                        <div class="flex items-center">
                            <a href="#" class="text-2xl font-bold gradient-text mr-6">FitTrack</a>

                            <nav class="hidden md:flex space-x-6">
                                <a href="/dashboard" class="flex items-center py-1 px-1 border-b-2 border-blue-500 text-blue-600 font-medium text-sm">
                                    <i data-lucide="layout-dashboard" class="mr-2" style="width: 16px; height: 16px;"></i>
                                    Dashboard
                                </a>
                                <a href="/activities" class="flex items-center py-1 px-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 font-medium text-sm">
                                    <i data-lucide="activity" class="mr-2" style="width: 16px; height: 16px;"></i>
                                    Activities
                                </a>
                                <a href="/health" class="flex items-center py-1 px-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 font-medium text-sm">
                                    <i data-lucide="trending-up" class="mr-2" style="width: 16px; height: 16px;"></i>
                                    Health Stats
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
    </div>

    <script>
        // Initialize icons
        lucide.createIcons();
    </script>
    </html>
' ?>