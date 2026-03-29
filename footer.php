<footer class="footer">
    <link rel="stylesheet" href="style.css">
    <div class="footer-container">

        <div class="footer-left">
            <img src="img/logo_preto_1.png" alt="TuneTest" class="footer-logo">
            <p>© <?php echo date('Y'); ?> HubSong. Todos os direitos reservados.</p>
        </div>

        <div class="footer-links">
            <a href="termo-artista.php">Aviso Legal para artistas</a>
            <span>·</span>
            <a href="privacidade.php">Privacidade</a>
            <span>·</span>
            <a href="termos.php">Termos de Uso</a>
            <span>·</span>
            <a href="sobre.php">Sobre a Startup</a>
        </div>
<div class="footer-version">
    HubSong • <?php echo defined('APP_VERSION') ? APP_VERSION : 'Beta 0.6.0'; ?>
</div>


    </div>
</footer>

<style>
    .footer-version {
    font-size: 11px;
    color: #b0b0b0;
}
.footer-links a:hover{
    color:#ccff00;
}
</style>