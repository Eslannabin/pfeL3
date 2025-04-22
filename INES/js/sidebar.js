// Sidebar toggle functionality
document.addEventListener('DOMContentLoaded', function() {
    const toggleBtn = document.querySelector('.toggle-btn');
    const sidebar = document.querySelector('#sidebar');

    toggleBtn.addEventListener('click', function() {
      sidebar.classList.toggle('expand');

      // Adjust main content margin
      const mainContent = document.querySelector('.main-content');
      if (sidebar.classList.contains('expand')) {
        mainContent.style.marginLeft = '50px';
      } else {
        mainContent.style.marginLeft = '50px';
      }
    });

    // Initialize with correct margin
    const mainContent = document.querySelector('.main-content');
    if (sidebar.classList.contains('expand')) {
      mainContent.style.marginLeft = '50px';
    } else {
      mainContent.style.marginLeft = '50px';
    }
  });