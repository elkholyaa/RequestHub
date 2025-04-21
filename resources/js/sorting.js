/**
 * Table Sorting Enhancement
 * 
 * This script enhances the sorting UI experience by adding animations and
 * visual feedback when users interact with sortable table headers.
 */

document.addEventListener('DOMContentLoaded', function() {
    // Find all the sortable table headers
    const sortableHeaders = document.querySelectorAll('.sort-indicator');
    
    // Add click animation for sort headers
    sortableHeaders.forEach(header => {
        header.addEventListener('click', function(e) {
            // Add a small ripple animation effect
            const ripple = document.createElement('span');
            ripple.classList.add('sort-ripple');
            
            // Position it at the click location
            const rect = header.getBoundingClientRect();
            ripple.style.left = (e.clientX - rect.left) + 'px';
            ripple.style.top = (e.clientY - rect.top) + 'px';
            
            header.appendChild(ripple);
            
            // Remove it after animation completes
            setTimeout(() => {
                ripple.remove();
            }, 500);
        });
    });
    
    // Highlight the currently sorted column
    highlightActiveSortColumn();
});

/**
 * Highlights the currently active sort column
 */
function highlightActiveSortColumn() {
    // Get current sort parameters from URL
    const urlParams = new URLSearchParams(window.location.search);
    const currentSort = urlParams.get('sort');
    const currentDirection = urlParams.get('direction');
    
    if (currentSort) {
        // Find the header that corresponds to the current sort
        const activeHeader = document.querySelector(`.sort-indicator[data-sort="${currentSort}"]`);
        
        if (activeHeader) {
            // Remove any existing sort classes
            document.querySelectorAll('.sort-indicator').forEach(header => {
                header.classList.remove('asc', 'desc');
            });
            
            // Add the appropriate direction class
            activeHeader.classList.add(currentDirection === 'asc' ? 'asc' : 'desc');
            
            try {
                // Find the column index of the sorted header
                const columnIndex = Array.from(activeHeader.closest('tr').querySelectorAll('th')).indexOf(activeHeader.closest('th'));
                
                if (columnIndex >= 0) {
                    // Highlight all cells in this column with a subtle background
                    const tableRows = document.querySelectorAll('.requests-table tbody tr');
                    
                    tableRows.forEach(row => {
                        // Clear previous highlights
                        row.querySelectorAll('td').forEach(cell => {
                            cell.classList.remove('bg-indigo-50');
                        });
                        
                        // Add highlight to the current column cell
                        const cells = row.querySelectorAll('td');
                        if (cells.length > columnIndex) {
                            const cell = cells[columnIndex];
                            if (cell) {
                                cell.classList.add('bg-indigo-50', 'transition-colors');
                            }
                        }
                    });
                    
                    // Add a slight pulse animation to the header
                    const headerCell = activeHeader.closest('th');
                    if (headerCell) {
                        headerCell.classList.add('sorted-column');
                        setTimeout(() => {
                            headerCell.classList.remove('sorted-column');
                        }, 1000);
                    }
                }
            } catch (e) {
                console.error('Error highlighting column:', e);
            }
        }
    }
} 