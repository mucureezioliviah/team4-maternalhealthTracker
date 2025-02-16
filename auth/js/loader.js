document.addEventListener('DOMContentLoaded', function() {
    const loadingOverlay = document.getElementById("loading-overlay");

    // Function to show the loading screen
    window.showLoading = function() {
        loadingOverlay.style.display = "flex";
    }

    // Function to hide the loading screen
    window.hideLoading = function() {
        loadingOverlay.style.display = "none";
    }

    // Ensure the overlay is hidden on page load
    hideLoading();
});
