// Toggle dropdown details for Lost Items
function toggleDetails(id) {
    var div = document.getElementById('details-' + id);
    if (div) {
        div.style.display = (div.style.display === 'block') ? 'none' : 'block';
    }
}

// Toggle dropdown details for Found Items
function toggleFoundDetails(id) {
    var div = document.getElementById('found-details-' + id);
    if (div) {
        div.style.display = (div.style.display === 'block') ? 'none' : 'block';
    }
}