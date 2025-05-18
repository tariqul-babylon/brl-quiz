// FAQ Accordion Functionality
document.addEventListener('DOMContentLoaded', function () {
    const questions = document.querySelectorAll('.faq-question');

    questions.forEach(question => {
        question.addEventListener('click', () => {
            const answer = question.nextElementSibling;
            const isOpen = question.classList.contains('active');

            // Close all answers first
            document.querySelectorAll('.faq-answer').forEach(ans => {
                ans.classList.remove('show');
            });
            document.querySelectorAll('.faq-question').forEach(q => {
                q.classList.remove('active');
            });

            // Open current if it was closed
            if (!isOpen) {
                question.classList.add('active');
                answer.classList.add('show');
            }
        });
    });

    // Tab functionality
    const tabs = document.querySelectorAll('.faq-tab');
    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            tabs.forEach(t => t.classList.remove('active'));
            tab.classList.add('active');
            // Here you would filter questions by category
            // This would require additional data attributes on questions
        });
    });

    // Search functionality
    const searchInput = document.querySelector('.faq-search-input');
    searchInput.addEventListener('input', (e) => {
        const searchTerm = e.target.value.toLowerCase();
        const questions = document.querySelectorAll('.faq-question');

        questions.forEach(question => {
            const questionText = question.textContent.toLowerCase();
            const answer = question.nextElementSibling;
            const answerText = answer.textContent.toLowerCase();
            const faqItem = question.parentElement;

            if (questionText.includes(searchTerm) || answerText.includes(searchTerm)) {
                faqItem.style.display = 'block';
            } else {
                faqItem.style.display = 'none';
            }
        });
    });
});