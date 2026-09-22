</main>
    <footer>
        <p>&copy; <?php echo date('Y'); ?> SIMPUS Mini. Praktikum Web Design & Development.</p>
    </footer>
    
    <!-- JS terhubung dinamis ke semua file PHP -->
    <script src="<?php echo isset($base) ? $base : ''; ?>assets/js/app.js"></script>
</body>
</html>