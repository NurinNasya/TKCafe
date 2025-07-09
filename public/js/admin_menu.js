
function openAddForm() {
    document.getElementById('addMenuModal').style.display = 'flex';
}

function closeAddForm() {
    document.getElementById('addMenuModal').style.display = 'none';
}

window.onclick = function(event) {
    const modal = document.getElementById('addMenuModal');
    if (event.target === modal) {
        modal.style.display = "none";
    }
}
