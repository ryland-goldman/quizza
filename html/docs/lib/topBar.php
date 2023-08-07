  <!-- Top bar -->
  <div id='top-bar'>
    <table id='top-bar-table<?php if($_SERVER['PHP_SELF']=="/index.php") { ?>-blue<?php } ?>'>
      <tr>
        <td class='td-outer'>&nbsp;</td>
        <td id='top-bar-table-logo'>
          <a href='/'>
            <h1><img style='height:1em;' id='logo<?php if($_SERVER['PHP_SELF']=="/index.php") { ?>-home<?php } ?>'></h1>
          </a>
        </td>
        <td id="top-bar-upper-icon" class='td-outer'>
          <table style='width:100%'>
            <tr>
              <td style='float:right;'>
                <div id="topbar-menuToggle">
                  <input type="checkbox" />
                  <span></span>
                  <span></span>
                  <span></span>
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
                      <?php } else { ?>
                        <tr>
                          <td>&nbsp;</td>
                          <td><div id="buttonDiv"></div></td>
                        </tr>
                      <?php } ?>
                      <tr>
                        <td>&nbsp;</td>
                        <td>
                          <a href='https://www.quizza.org/private' class='top-bar-name'>Private Sets</a>
                        </td>
                      </tr>
                      <?php if($loggedIn){ ?>
                        <tr>
                          <td>&nbsp;</td>
                          <td>
                            <a href='javascript:signout()' class='top-bar-name top-bar-signout'>Sign Out</a>
                          </td>
                        </tr>
                      <?php } ?>
                    </table>
                    <br>
                    <hr>
                    <br>
                    <div class='left-float'>
                      <div class='select'>
                        <select>
                          <?php if($_SERVER['HTTP_HOST']=="www.quizza.org" && $_SERVER['PHP_SELF']=="/index.php"){ ?><option selected>Select a School</option><?php } ?>
                          <option value="private"<?php if($private_set) {?> selected<?php } ?>>Private Sets (No School Needed)</option>
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
      </tr>
    </table>
  </div>

  <!-- Match the height of the above bar -->
  <div><table><tr><td style='padding:13px 20px 5px;'><h1>&nbsp;</h1></td></tr></table></div>