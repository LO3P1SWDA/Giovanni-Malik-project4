document.getElementById('searchBox').addEventListener('input', function() {
    let searchTerm = this.value.toLowerCase();
    let users = document.querySelectorAll('#userList section');
    users.forEach(user => {
        if (user.textContent.toLowerCase().startsWith(searchTerm)) {
            user.style.display = '';
        } else {
            user.style.display = 'none';
        }
    });
});