<!-- Footer -->
<div id='footer'<?php if($_SERVER['PHP_SELF']=="/index.php" && !isset($mainphp)) { ?> style='color:#eee;'<?php } ?>>
    <p>
        Copyright &copy; 2022-24 Ryland Goldman and Collin Wentzien<br>
        For feedback or suggestions, use our <a target="_blank" href='https://github.com/ryland-goldman/quizza/issues'<?php if($_SERVER['PHP_SELF']=="/index.php" && !isset($mainphp)) { ?> style='color:white;'<?php } ?>>GitHub</a> page.<br>
        <a href='https://www.quizza.org/static/files/TOS.html' <?php if($_SERVER['PHP_SELF']=="/index.php" && !isset($mainphp)) { ?> style='color:white;'<?php } ?>>Privacy and Terms</a> • <a href='https://forms.gle/YfAH3qHdQGswbfN39' target="_blank" <?php if($_SERVER['PHP_SELF']=="/index.php" && !isset($mainphp)) { ?> style='color:white;'<?php } ?>>Report Content</a>
    </p>
</div>
<?php if(!isset($bmac) && !isMobileDevice()) { ?>
    <script data-name="BMC-Widget" data-cfasync="false" src="https://cdnjs.buymeacoffee.com/1.0.0/widget.prod.min.js" data-id="quizza" data-description="Support me on Buy me a coffee!" data-message="" data-color="#40DCA5" data-position="Center" data-x_margin="18" data-y_margin="18"></script>
<?php } ?>