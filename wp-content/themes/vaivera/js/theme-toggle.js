/**
 * Theme Toggle Functionality
 * Handles light/dark mode switching
 */

document.addEventListener('DOMContentLoaded', function () {
    console.log('Theme toggle script loaded');

    const toggleButton = document.getElementById('theme-toggle');

    if (!toggleButton) {
        console.error('Theme toggle button not found');
        return;
    }

    console.log('Theme toggle button found');

    // Get the current theme from localStorage or default to light
    function getCurrentTheme() {
        const savedTheme = localStorage.getItem('xarop-theme');
        if (savedTheme) {
            return savedTheme;
        }

        // Always default to light theme, ignore system preference
        return 'light';
    }

    // Apply theme to document
    function applyTheme(theme) {
        console.log('Applying theme:', theme);
        document.documentElement.setAttribute('data-theme', theme);
        document.body.setAttribute('data-theme', theme);
        localStorage.setItem('xarop-theme', theme);

        // Update button aria-label
        const label = theme === 'dark' ? 'Switch to light mode' : 'Switch to dark mode';
        toggleButton.setAttribute('aria-label', label);
    }

    // Toggle between light and dark themes
    function toggleTheme() {
        const currentTheme = getCurrentTheme();
        const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
        console.log('Toggling from', currentTheme, 'to', newTheme);
        applyTheme(newTheme);
    }

    // Initialize theme on page load
    function initTheme() {
        const currentTheme = getCurrentTheme();
        console.log('Initializing theme:', currentTheme);

        // Only apply theme if it's not already set to prevent conflicts with header script
        const currentDataTheme = document.documentElement.getAttribute('data-theme');
        if (!currentDataTheme || currentDataTheme !== currentTheme) {
            applyTheme(currentTheme);
        } else {
            // Ensure body also has the theme attribute if it wasn't set
            if (document.body && document.body.getAttribute('data-theme') !== currentTheme) {
                document.body.setAttribute('data-theme', currentTheme);
            }

            // Update button aria-label
            const label = currentTheme === 'dark' ? 'Switch to light mode' : 'Switch to dark mode';
            toggleButton.setAttribute('aria-label', label);
        }
    }

    // Add click event listener to toggle button
    toggleButton.addEventListener('click', function (e) {
        e.preventDefault();
        console.log('Toggle button clicked');
        toggleTheme();
    });

    // Initialize theme
    initTheme();

    // Removed automatic system theme change listener
    // Theme will only change when user manually toggles it
});