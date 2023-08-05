  <!-- Links -->
  <link rel='icon' href='https://www.quizza.org/static/images/favicon.png'>
  <link rel="stylesheet" href="https://www.quizza.org/static/stylesheets/main.css">
  <link rel="stylesheet" href="https://www.quizza.org/static/stylesheets/jquery.modal.min.css">

  <!-- Scripts -->
  <script src="https://kit.fontawesome.com/9e91fc9fc4.js" crossorigin="anonymous"></script>
  <script src="https://www.quizza.org/static/scripts/jquery.min.js"></script>
  <script src="https://www.quizza.org/static/scripts/jquery.modal.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.debug.js"></script>
  <script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
  <script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3.0.1/es5/tex-mml-chtml.js"></script>
  <?php if ($loggedIn == false) { ?><script src="https://accounts.google.com/gsi/client" async defer></script><?php } ?>
  <?php if ($loggedIn == false) { ?><script src="https://www.quizza.org/static/scripts/login.js"></script><?php } ?>
  <?php if ($loggedIn == true) { ?><script>function signout(){ $.get("/docs/lib/login-endpoint/signout.php", function(d,s){location.reload();});}</script><?php } ?>

  <!-- Metadata -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <meta name="theme-color" content="#12DCB6" />
  <?php if ($loggedIn == false) { ?><meta content="117895756240-ujiuojlsbtruthgqnghnu215d2hn7flp.apps.googleusercontent.com" name="google-signin-client_id" /><?php } ?>
