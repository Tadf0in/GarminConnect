// Only for display the bar for the admin !!
async function renderUserSidebar(apiUrl, selectedUserIds = []) {
    try {
        // Fetch user data
        const response = await fetch(apiUrl, {
            headers: {
                'Accept': 'application/json',
            },
        });
        const users = await response.json();

        if (!Array.isArray(users)) {
            console.error('Invalid user data received.');
            return;
        }

        // Sidebar markup
        const sidebar = document.createElement('aside');
        sidebar.className = 'w-64 bg-gray-100 h-screen p-4 overflow-auto';

        const heading = document.createElement('h2');
        heading.className = 'text-xl font-semibold mb-4';
        heading.textContent = 'User List';
        sidebar.appendChild(heading);

        const form = document.createElement('form');
        form.id = 'user-sidebar-form';

        users.forEach(user => {
            const id = user.id;
            const name = user.name;
            const checked = selectedUserIds.includes(id);

            const label = document.createElement('label');
            label.className = 'flex items-center mb-2';

            const checkbox = document.createElement('input');
            checkbox.type = 'checkbox';
            checkbox.name = 'users[]';
            checkbox.value = id;
            checkbox.className = 'form-checkbox h-5 w-5 text-blue-600 mr-2';
            if (checked) checkbox.checked = true;

            const span = document.createElement('span');
            span.className = 'text-gray-700';
            span.textContent = name;

            label.appendChild(checkbox);
            label.appendChild(span);
            form.appendChild(label);
        });

        sidebar.appendChild(form);
        document.body.appendChild(sidebar);
    } catch (error) {
        console.error('Failed to load users:', error);
    }
}
//renderUserSidebar('http://127.0.0.1:5000/user/', [1, 2, 3, 4, 5]);

async function renderUserSidebarTest(apiUrl, selectedUserIds = []) {
    try {
        // === MOCKING START ===
        const users = [
            { id: 1, name: 'Alice' },
            { id: 2, name: 'Bob' },
            { id: 3, name: 'Charlie' },
            { id: 4, name: 'Dana' },
            { id: 5, name: 'Eve' },
            { id: 6, name: 'Frank' },
            { id: 7, name: 'Grace' },
            { id: 8, name: 'Heidi' },
            { id: 9, name: 'Ivan' },
            { id: 10, name: 'Judy' },
            { id: 11, name: 'Karl' },
            { id: 12, name: 'Leo' },
            { id: 13, name: 'Mallory' },
            { id: 14, name: 'Nina' },
            { id: 15, name: 'Oscar' },
            { id: 16, name: 'Peggy' },
            { id: 17, name: 'Quentin' },
            { id: 18, name: 'Rupert' },
            { id: 19, name: 'Sybil' },
            { id: 20, name: 'Trent' }
        ];
        // === MOCKING END ===

        // Sidebar markup
        const sidebar = document.createElement('aside');
        sidebar.className = 'w-[12%] h-screen p-4 overflow-auto';

        const heading = document.createElement('h2');
        heading.className = 'text-xl font-semibold mb-4 hover:text-blue-600 transition duration-200 ease-in-out';
        heading.textContent = 'Liste des utilisateurs';
        sidebar.appendChild(heading);

        const form = document.createElement('form');
        form.id = 'user-sidebar-form';

        users.forEach(user => {
            const id = user.id;
            const name = user.name;
            const isSelected = selectedUserIds.includes(id);

            const label = document.createElement('div');
            label.className = `cursor-pointer px-2 py-1 rounded mb-2 transition-colors duration-150 ${
                isSelected ? 'bg-blue-300' : 'hover:bg-blue-100'
            }`;
            label.textContent = name;
            label.dataset.userId = id;

            if (isSelected) {
                label.classList.add('bg-blue-300');
            }

            label.addEventListener('click', () => {
                label.classList.toggle('bg-blue-300');
                label.classList.toggle('hover:bg-blue-100');
            });

            form.appendChild(label);
        });

        sidebar.appendChild(form);
        document.body.appendChild(sidebar);
    } catch (error) {
        console.error('Failed to load users:', error);
    }
}

renderUserSidebarTest('', [1, 2, 3, 4, 5]);