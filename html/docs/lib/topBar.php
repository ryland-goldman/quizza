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
                    <?php if($loggedIn){ ?>
                        <table id='tr-border-bottom-table'>
                          <tr>
                            <td>
                              <img src='<?php echo $pic; ?>' id='top-bar-icon-image'>
                            </td>
                            <td>
                              <a href='https://www.quizza.org/private' id='top-bar-name'>Welcome, <?php echo $name; ?></a><br>
                              <a href='javascript:signout()' id='top-bar-signout'>Sign Out</a>
                            </td>
                          </tr>
                          <tr id='tr-border-bottom'>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                          </tr>
                        </table>
                    <?php } else { ?>
                      <table id='tr-border-bottom-table'>
                          <tr>
                            <td>
                              <div id="buttonDiv"></div>
                            </td>
                            <td>
                              &nbsp;
                            </td>
                          </tr>
                          <tr id='tr-border-bottom'>
                            <td>&nbsp;</td>
                          </tr>
                        </table>
                    <?php } ?>
                    <br>
                    <div class='left-float'>
                      <div class='select'>
                        <select>
                          <?php if($_SERVER['HTTP_HOST']=="www.quizza.org" && $_SERVER['PHP_SELF']=="/main.php"){ ?><option selected>Select a School</option><?php } ?>
                          <?php if(!$private_set){ ?><option value="private">Private Sets (No School Needed)</option><?php } ?>
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
