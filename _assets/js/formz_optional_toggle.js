(function() {
    'use strict';
    
    const toggleBtn = document.getElementById('optional-fields-toggle-btn');
    const container = document.getElementById('optional-fields-container');
    const gradient = document.getElementById('optional-fields-gradient');
    
    if (!toggleBtn || !container) {
        return;
    }
    
    toggleBtn.addEventListener('click', function() {
        container.style.display = 'block';
        container.classList.add('show');
        
        toggleBtn.style.display = 'none';
        
        if (gradient) {
            gradient.style.display = 'none';
        }
    });
})();
