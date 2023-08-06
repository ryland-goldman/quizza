  <!-- Top bar -->
  <div id='top-bar'>
    <table id='top-bar-table<?php if($_SERVER['PHP_SELF']=="/index.php") { ?>-blue<?php } ?>'>
      <tr>
        <td id='top-bar-table-logo'>
          <a href='/'>
            <h1><img style='height:1em;' id='logo<?php if($_SERVER['PHP_SELF']=="/index.php") { ?>-home<?php } ?>'></h1>
          </a>
        </td>
        <td>&nbsp;</td>
        <td id="top-bar-upper-icon">
          <table style='float:right;'>
            <tr>
              <td>&nbsp;</td>
              <td>
                <div id="topbar-menuToggle">
                  <input type="checkbox" />
                  <span></span>
                  <span></span>
                  <span></span>
                  <div id="topbar-menu">
                    <p>
                      <?php if($loggedIn){ ?>
                        <table style='float:right;'>
                          <tr>
                            <td>
                              <a href='https://www.quizza.org/private' id='top-bar-name'>Welcome, <?php echo $name; ?></a><br>
                              <a href='javascript:signout()' id='top-bar-signout'>Sign Out</a>
                            </td>
                            <td>
                              <img src='<?php echo $pic; ?>' id='top-bar-icon-image'>
                            </td>
                          </tr>
                        </table>
                      <?php } else { ?><div id="buttonDiv"></div><?php } ?>
                    </p>
                    <hr>
                    <p>Change School</p>
                    <select>
                      <?php if(!$private_set){ ?><option value="www" selected><?php echo $school_shortname; ?></option><?php } ?>
                      <option value="private">Private Sets</option>
                      <?php $schools = $schooldb->query("SELECT * FROM main");
                      while($curr_school = $schools->fetch_assoc()){ 
                        if($curr_school["shortname"] !== $school_shortname){ ?>
                          <option value="<?php echo $curr_school["id"]; ?>"><?php echo $curr_school["shortname"]; ?></option>
                      <?php } } ?>
                    </select>
                  </div>
                </div>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
  </div>

  <!-- Match the height of the above bar -->
  <div><table><tr><td style='padding:13px 20px 5px;'><h1>&nbsp;</h1></td></tr></table></div>
