  <!-- Top bar -->
  <div id='top-bar'>
    <table id='top-bar-table<?php if($_SERVER['PHP_SELF']=="/index.php") { ?>-blue<?php } ?>'>
      <tr>
        <td class='td-outer'>&nbsp;</td>
        <td id='top-bar-table-logo'>
          <a href='<?php if($_SERVER['PHP_SELF']=="/index.php") { ?>https://www.quizza.org<?php } ?>/'>
            <h1><img style='height:1em;' id='logo<?php if($_SERVER['PHP_SELF']=="/index.php") { ?>-home<?php } ?>'></h1>
          </a>
        </td>
        <?php if (!isMobileDevice()) { ?><td>&nbsp;</td>
        <td id="top-bar-upper-icon">
          <table style='float:right;'>
            <tr>
              <?php if ($loggedIn == false) { ?><td><div id="buttonDiv"></div></td><?php } ?>
              <?php if ($loggedIn == true) { ?><td<?php if($_SERVER['PHP_SELF']=="/index.php") { ?> style='color:white;'<?php } ?>>
                <a style='white-space:nowrap;overflow:hidden;float:right;' href='https://www.quizza.org/private' class='top-bar-name'>Welcome, <?php echo $name; ?></a><br>
                <span style='font-size:9pt;float:right;margin-top:2px;'>
                  <a href='https://www.quizza.org/private' class='top-bar-private'>Private Sets</a> • 
                  <a href='#change-school' rel='modal:open'>Change School</a> • 
                  <a href='javascript:signout()' class='top-bar-signout'>Sign Out</a>
                </span>
              </td>
              <td>&nbsp;</td>
              <td>
                <img src='<?php echo $pic; ?>' id='top-bar-icon-image'>
              </td>
              <?php } ?>
            </tr>
          </table>
        </td>
        <?php } else { ?>
        <td id="top-bar-upper-icon" class='td-outer'>
          <table style='width:100%'>
            <tr>
              <td style='float:right;'>
                <div id="topbar-menuToggle">
                  <input type="checkbox" />
                  <span class='topbar-menuToggle-span'></span>
                  <span class='topbar-menuToggle-span'></span>
                  <span class='topbar-menuToggle-span'></span>
                  <div id="topbar-menu">
                    <table class='signin-table'>
                      <?php if($loggedIn) { ?>
                        <tr>
                          <td>
                            <img src='<?php echo $pic; ?>' id='top-bar-icon-image'>
                          </td>
                          <td>
                            <a href='https://www.quizza.org/private' class='top-bar-name'><strong><?php echo $name; ?></strong></a>
                          </td>
                        </tr>
                        <tr>
                          <td><img src='<?php echo $pic; ?>' class='top-bar-icon-image-hidden'></td>
                          <td>
                            <a href='https://www.quizza.org/private' class='top-bar-name'>Private Sets</a>
                          </td>
                        </tr>
                        <tr>
                          <td><img src='<?php echo $pic; ?>' class='top-bar-icon-image-hidden'></td>
                          <td>
                            <a href='javascript:signout()' class='top-bar-name top-bar-signout'>Sign Out</a>
                          </td>
                        </tr>
                      <?php } else { ?>
                        <tr>
                          <td>&nbsp;</td>
                          <td><div id="buttonDiv"></div></td>
                        </tr>
                      <?php } ?>
                    </table>
                    <br>
                    <hr>
                    <br>
                    <div>
                      <div class='select' style='float:unset;'>
                        <select>
                          <?php if($_SERVER['HTTP_HOST']=="www.quizza.org"){ ?><option selected>Select a School</option><?php } ?>
                          <?php 
                          try {
                            $sql_db_password =  trim(file_get_contents("/var/www/sql.privkey"));
                            $schooldb = new mysqli("localhost","quizza", $sql_db_password, "Schools");
                          } catch (Exception $e) {}
                          $schools = $schooldb->query("SELECT * FROM main ORDER BY longname ASC;");
                          while($curr_school = $schools->fetch_assoc()){ ?>
                            <option value="<?php echo $curr_school["id"]; ?>"<?php if($curr_school["shortname"] == $school_shortname){ ?> selected<?php } ?>><?php echo $curr_school["longname"]; ?></option>
                          <?php } ?>
                        </select>
                        <div class="select-after">
                          <i class="fa-solid fa-caret-down"></i>&nbsp;
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </td>
            </tr>
          </table>
        </td>
        <?php } ?>
      </tr>
    </table>
  </div>

  <!-- Match the height of the above bar -->
  <div><table><tr><td style='padding:13px 20px 5px;'><h1>&nbsp;</h1></td></tr></table></div>

  <?php if(!isMobileDevice()){ ?>
    <div class='modal' id='change-school'>
      <h2>Change School</h2>
      <div class='select' style='float:unset;'>
        <select>
          <?php if($_SERVER['HTTP_HOST']=="www.quizza.org"){ ?><option selected>Select a School</option><?php } ?>
          <?php 
          try {
            $sql_db_password =  trim(file_get_contents("/var/www/sql.privkey"));
            $schooldb = new mysqli("localhost","quizza", $sql_db_password, "Schools");
          } catch (Exception $e) {}
          $schools = $schooldb->query("SELECT * FROM main ORDER BY longname ASC;");
          while($curr_school = $schools->fetch_assoc()){ ?>
            <option value="<?php echo $curr_school["id"]; ?>"<?php if($curr_school["shortname"] == $school_shortname){ ?> selected<?php } ?>><?php echo $curr_school["longname"]; ?></option>
          <?php } ?>
        </select>
        <div class="select-after">
          <i class="fa-solid fa-caret-down"></i>&nbsp;
        </div>
      </div>
    </div>
  <?php } ?>