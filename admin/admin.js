document.addEventListener('DOMContentLoaded', () => {
    const loginSection = document.getElementById('login-section');
    const uploadSection = document.getElementById('upload-section');
    const newsUploadSection = document.getElementById('news-upload-section');
    const loginForm = document.getElementById('login-form');
    const uploadForm = document.getElementById('upload-form');
    const newsUploadForm = document.getElementById('news-upload-form');

    loginForm.addEventListener('submit', (event) => {
        event.preventDefault();
        const username = document.getElementById('username').value;
        const password = document.getElementById('password').value;

        if (username === 'admin' && password === 'admin') {
            loginSection.style.display = 'none';
            uploadSection.style.display = 'block';
            newsUploadSection.style.display = 'block';
        } else {
            alert('Invalid username or password');
        }
    });

    uploadForm.addEventListener('submit', (event) => {
        event.preventDefault();
        
        const title = document.getElementById('title').value;
        const description = document.getElementById('description').value;
        const imageUrl = document.getElementById('image-url').value;
        const pdfFile = document.getElementById('pdf-file').files[0];

        if (title && description && imageUrl && pdfFile) {
            const fileUrl = URL.createObjectURL(pdfFile);

            let downloads = JSON.parse(localStorage.getItem('downloads')) || [];
            const newDownload = {
                id: downloads.length + 1,
                title: title,
                description: description,
                image: imageUrl,
                file: fileUrl
            };
            downloads.push(newDownload);
            localStorage.setItem('downloads', JSON.stringify(downloads));

            alert('File uploaded successfully!');
            uploadForm.reset();
        } else {
            alert('Please fill in all fields.');
        }
    });

    newsUploadForm.addEventListener('submit', (event) => {
        event.preventDefault();

        const title = document.getElementById('news-title').value;
        const description = document.getElementById('news-description').value;
        const imageUrl = document.getElementById('news-image-url').value;
        const content = document.getElementById('news-content').value;

        if (title && description && imageUrl && content) {
            let news = JSON.parse(localStorage.getItem('news')) || [];
            const newNews = {
                id: news.length + 1,
                title: title,
                description: description,
                image: imageUrl,
                content: content
            };
            news.push(newNews);
            localStorage.setItem('news', JSON.stringify(news));

            alert('News article uploaded successfully!');
            newsUploadForm.reset();
        } else {
            alert('Please fill in all fields.');
        }
    });
});
