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

    // Get the current theme from localStorage or system preference
    function getCurrentTheme() {
        const savedTheme = localStorage.getItem('xarop-theme');
        if (savedTheme) {
            return savedTheme;
        }

        // Check system preference
        if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
            return 'dark';
        }

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
        applyTheme(currentTheme);
    }

    // Add click event listener to toggle button
    toggleButton.addEventListener('click', function (e) {
        e.preventDefault();
        console.log('Toggle button clicked');
        toggleTheme();
    });

    // Initialize theme
    initTheme();

    // Listen for system theme changes
    if (window.matchMedia) {
        const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
        mediaQuery.addEventListener('change', function (e) {
            // Only auto-switch if user hasn't manually set a preference
            if (!localStorage.getItem('xarop-theme')) {
                const newTheme = e.matches ? 'dark' : 'light';
                applyTheme(newTheme);
            }
        });
    }
});