  <!-- Top bar -->
  <div id='top-bar'>
    <table id='top-bar-table<?php if($_SERVER['PHP_SELF']=="/index.php") { ?>-blue<?php } ?>'>
      <tr>
        <td id='top-bar-table-logo'>
          <a href='/'>
            <h1><img style='height:1em;' id='logo<?php if($_SERVER['PHP_SELF']=="/index.php") { ?>-home<?php } ?>'></h1>
          </a>
        </td>
        <?php if (!isMobileDevice()) { ?><td>&nbsp;</td>
        <td id="top-bar-upper-icon">
          <table style='float:right;'>
            <tr>
              <td>&nbsp;</td>
              <?php if ($loggedIn == false) { ?><td><div id="buttonDiv"></div></td><?php } ?>
              <?php if ($loggedIn == true) { ?><td<?php if($_SERVER['PHP_SELF']=="/index.php") { ?> style='color:white;'<?php } ?>>
                <a href='https://www.quizza.org/private' id='top-bar-name'>Welcome, <?php echo $name; ?>.</a>
              </td>
              <td>
                <img src='<?php echo $pic; ?>' id='top-bar-icon-image'>
              </td>
              <?php } ?>
            </tr>
          </table>
        </td> <?php } ?>
      </tr>
    </table>
  </div>

  <!-- Match the height of the above bar -->
  <div><table><tr><td style='padding:13px 20px 5px;'><h1>&nbsp;</h1></td></tr></table></div>
