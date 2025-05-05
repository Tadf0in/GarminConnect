<?php
/**
 * Sidebar component to list users with checkboxes.
 * Usage:
 *   include 'sidebar.php';
 *   renderUserSidebar($apiUrl, $selectedUserIds);
 *
 * @param string $apiUrl URL to fetch the users (e.g., '/user')
 * @param array  $selectedUserIds Array of user IDs to pre-check
 */
function renderUserSidebar(string $apiUrl = '/user', array $selectedUserIds = []) {
    // Fetch user data
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Accept: application/json',
    ]);
    $response = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);

    if ($error) {
        echo '<div class="p-4 bg-red-100 text-red-700">Failed to load users: '.htmlspecialchars($error).'</div>';
        return;
    }

    $users = json_decode($response, true);
    if (!is_array($users)) {
        echo '<div class="p-4 bg-red-100 text-red-700">Invalid user data received.</div>';
        return;
    }

    // Sidebar markup
    echo '<aside class="w-64 bg-gray-100 h-screen p-4 overflow-auto">';
    echo '<h2 class="text-xl font-semibold mb-4">User List</h2>';
    echo '<form id="user-sidebar-form">';

    foreach ($users as $user) {
        $id   = htmlspecialchars($user['id']);
        $name = htmlspecialchars($user['name']);
        $checked = in_array($user['id'], $selectedUserIds) ? 'checked' : '';

        echo '<label class="flex items-center mb-2">';
        echo "<input type=\"checkbox\" name=\"users[]\" value=\"{$id}\" class=\"form-checkbox h-5 w-5 text-blue-600 mr-2\" {$checked}>";
        echo "<span class=\"text-gray-700\">{$name}</span>";
        echo '</label>';
    }

    echo '</form>';
    echo '</aside>';
}
?>
