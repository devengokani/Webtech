    <footer>
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> WebTech. All Rights Reserved.</p>
            <div class="social-links">
                <a href="#">Facebook</a>
                <a href="#">Google</a>
                <a href="#">Instagram</a>
                <a href="#">Github</a>
                
            </div>
        </div>
    </footer>
    <script src="js/script.js"></script>
    <?php
    if (isset($js_files)) {
        foreach ($js_files as $js_file) {
            echo '<script src="js/' . htmlspecialchars($js_file) . '.js"></script>';
        }
    }
    ?>
</body>
</html>