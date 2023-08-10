  <!-- Links -->
  <link rel='icon' href='https://www.quizza.org/static/images/favicon.png'>
  <link rel="stylesheet" href="https://www.quizza.org/static/stylesheets/main.css">
  <link rel="preload" href="https://www.quizza.org/static/stylesheets/jquery.modal.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
  <link rel="preload" href="https://www.quizza.org/static/fonts/gotham-reg.woff2" as="font">
  <link rel="preload" href="https://www.quizza.org/static/fonts/gotham-bold.woff2" as="font">

  <!-- Metadata -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <meta name="theme-color" content="#12DCB6" />
  <?php if ($loggedIn == false) { ?><meta content="117895756240-ujiuojlsbtruthgqnghnu215d2hn7flp.apps.googleusercontent.com" name="google-signin-client_id" /><?php } ?>

  <!-- Scripts -->
  <script src="https://kit.fontawesome.com/9e91fc9fc4.js" crossorigin="anonymous"></script>
  <script src="https://www.quizza.org/static/scripts/jquery.min.js"></script>
  <script src="https://www.quizza.org/static/scripts/jquery.modal.min.js" defer></script>
  <script src="https://www.quizza.org/static/scripts/allpages.js"></script>
  <?php if(isset($mathjax)) { ?><script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3.0.1/es5/tex-mml-chtml.js"></script><?php } ?>
  <?php if(!isset($mathjax)) { ?><script>class f{constructor(){this.typeset=function(){}}};var MathJax=new f();</script><?php } /* avoid triggering mathjax error */ ?>
  <?php if ($loggedIn == false) { ?><script src="https://accounts.google.com/gsi/client"></script><?php } ?>
  <?php if ($loggedIn == false) { ?><script src="https://www.quizza.org/static/scripts/login.js"></script><?php } ?>