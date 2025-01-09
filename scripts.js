// Handle likes using AJAX
document.addEventListener('DOMContentLoaded', function () {
    const likeButtons = document.querySelectorAll('.like-button');

    likeButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const postId = this.getAttribute('data-post-id');

            fetch('../user/likes.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `post_id=${postId}`
            })
                .then(response => response.text())
                .then(data => {
                    console.log('Post liked:', data);
                    this.textContent = 'Liked';
                })
                .catch(error => console.error('Error:', error));
        });
    });
});
