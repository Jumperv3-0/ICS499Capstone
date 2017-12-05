<?php
//var_dump($gsale);
//var_dump($gsale->getData()->sale_name);
// FIXME: check to see if user own sale before displaying page
// FIXME: validate input for gsale
$user = new User();
if (!$user->hasSale($gsale->getData()->gsale_id)) {
  Redirect::page('404.php');
}
?>

  <div class="container">
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
      <div class="row">
        <div class="col-sm-12">
          <div class="form-group">
            <label for="sale_name">Name of sale:</label>
            <input type="text" class="form-control" id="sale_name" name="sale_name" value="<?php echo(isset($gsale) ? $gsale->getData()->sale_name : ''); ?>" placeholder="Enter name of sale">
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-3">
          <div class="row">
            <div class="col-xs-12">
              <div class="form-group">
                <?php
              if (isset($gsale) && !empty($gsale->getData()->image_url)) {
                echo "<img src='{$gsale->getData()->image_url}' alt='Picture of garage sale' style='width:100%;'>";
              } else {
                echo '<img src="https://dummyimage.com/200x200/333/fff.png&text=No+image+uploaded" alt="Picture of garage sale" style="width:100%;">';
              }
              ?>
                  <label for="image">Change image:</label>
                  <input type="file" id="image" name="image[]">
              </div>
            </div>
          </div>
        </div>
        <!-- TODO: fix width of col-sm-8 to col-sm-9 othersales page -->
        <div class="col-sm-9">
          <div id="date-time" class="form-group">
            <div class="row">
              <div class="col-sm-3">
                <label for="date1">Date:</label>
              </div>
              <div class="col-sm-3">
                <label for="startTime1">Start Time:</label>
              </div>
              <div class="col-sm-3">
                <label for="endTime1">End Time:</label>
              </div>
            </div>
            <!-- TODO: make dynamic for number of dates -->
            <?php
          $dates = DateTimeFormater::getDates($gsale->getData()->dates);
          $start_times = DateTimeFormater::getStartTimes($gsale->getData()->dates);
          $end_times = DateTimeFormater::getEndTimes($gsale->getData()->dates);
          $first = true;
          $count = 1;
          foreach ($dates as $date) {

            if ($first) {
              echo '<div class="row">
                      <div class="col-sm-3 form-group">
                        <input class="form-control" type="text" id="date' . $count . '" name="date[]" placeholder="mm/dd/yyyy" value="' . $date . '">
                      </div>
                      <div class="col-sm-3 form-group">
                        <input class="form-control" type="time" id="startTime' . $count . '" name="startTime[]" value="' . $start_times[$count-1] . '">
                      </div>
                      <div class="col-sm-3 form-group">
                        <input class="form-control" type="time" id="endTime' . $count . '" name="endTime[]" value="' . $end_times[$count-1] . '">
                      </div>
                      <div class="col-sm-3 form-group">
                        <button type="button" class="btn btn-green-no-padding form-control" id="add_date" onclick="addDateYourSales()">Add Day&nbsp;<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        </button>
                      </div>
                    </div>';
            } else {
              echo '<div class="row" id="row2">
                      <div class="col-xs-12 col-sm-3 form-group">
                        <input class="form-control" type="text" name="date[]" placeholder="mm/dd/yyyy" id="date' . $count . '" value="' . $date . '">
                      </div>
                      <div class="col-xs-12 col-sm-3 form-group">
                        <input class="form-control" type="time" name="startTime[]" id="startTime' . $count . '" value="' . $start_times[$count-1] . '">
                      </div>
                      <div class="col-xs-12 col-sm-3 form-group">
                        <input class="form-control" type="time" name="endTime[]" id="endTime' . $count . '" value="' . $end_times[$count-1] . '">
                      </div>
                      <div class="col-xs-12 col-sm-3 form-group">
                        <button class="btn btn-danger form-control" type="button" name="button[]" id="button2" onclick="removeDate(this)">Delete <span class="glyphicon glyphicon-minus" aria-hidden="true"></span></button>
                      </div>
                    </div>';
            }
            $count++;
            $first = false;
            echo "
            <script>
            var numberOfDays = {$count};
            /**
           * Makes a date
           * @author Gary
           * @param   {int}     number of date selectors on page
           * @returns {element} of new date input selectors
           */
            function makeDateYourSales(number) {
              var row = document.createElement('div');
              var child1 = document.createElement('div');
              var child2 = document.createElement('div');
              var child3 = document.createElement('div');
              var child4 = document.createElement('div');
              var input1 = document.createElement('input');
              var input2 = document.createElement('input');
              var input3 = document.createElement('input');
              var input4 = document.createElement('button');
              row.className = 'row';
              child1.className = 'col-xs-12 col-sm-3 form-group';
              child2.className = 'col-xs-12 col-sm-3 form-group';
              child3.className = 'col-xs-12 col-sm-3 form-group';
              child4.className = 'col-xs-12 col-sm-3 form-group';
              input1.className = 'form-control';
              input2.className = 'form-control';
              input3.className = 'form-control';
              input4.className = 'btn btn-danger form-control';
              input1.type = 'text';
              input2.type = 'time';
              input3.type = 'time';
              input4.type = 'button';
              input1.name = 'date[]';
              input2.name = 'startTime[]';
              input3.name = 'endTime[]';
              input4.name = 'button[]';
              row.id = 'row' + number;
              input1.placeholder =\"mm/dd/yyyy\";
              input1.id = 'date' + number;
              input2.id = 'startTime' + number;
              input3.id = 'endTime' + number;
              input4.id = 'button' + number;
              input4.innerHTML = 'Delete <span class=\"glyphicon glyphicon-minus\" aria-hidden=\"true\"></span>';
              input4.onclick = function() {
                document.getElementById('date-time').removeChild(row);
                numberOfDays--;
              };
              row.appendChild(child1);
              row.appendChild(child2);
              row.appendChild(child3);
              row.appendChild(child4);
              child1.appendChild(input1);
              child2.appendChild(input2);
              child3.appendChild(input3);
              child4.appendChild(input4);
              return row;
            }

            /**
             * Adds a date selector to the date-time div
             * @author Gary
             */
            function addDateYourSales() {
              var page = encodeURI(location.href);
              if (numberOfDays <= 7 && page.indexOf(\"yourSales.php\") != -1) {
                var o = document.getElementById('date-time');
                var childList = o.childNodes;
                o.insertBefore(makeDateYourSales(numberOfDays++), childList[childList.length - 1]);
              }
            }
          </script>";
          }
          ?>

          </div>
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="phone" class="form-control" id="phone" name="phone" placeholder="(XXX)-XXX-XXXX" onkeypress="phoneFormat()" value="<?php
                                                                                                                                              $db_conn = SqlManager::getInstance();
                                                                                                                                              $sql = " SELECT phone_id, phone_number FROM phones JOIN garage_sales_phones ON phones.phone_id=garage_sales_phones.phone_fk_id WHERE garage_sales_phones.garage_sale_fk_id=? ; ";
                                                                                                                                              $result = $db_conn->query($sql, array($gsale->getData()->gsale_id));
                                                                                                                                              echo $result->getResult()[0]->phone_number;
                                                                                                                                              ?>" maxlength="16">
                <input type="hidden" name="phone_id" value="<?php
                                                          $db_conn = SqlManager::getInstance();
                                                          $sql = " SELECT phone_id, phone_number FROM phones JOIN garage_sales_phones ON phones.phone_id=g arage_sales_phones.phone_fk_id WHERE garage_sales_phones.garage_sale_fk_id=? ; ";
                                                          $result = $db_conn->query($sql, array($gsale->getData()->gsale_id));
                                                          echo $result->getResult()[0]->phone_id;
                                                          ?>">
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12">
          <div id="locationField" class="form-group">
            <label for="location">Location:</label>
            <input type="location" class="form-control" id="location" onfocus="geolocate()" name="location" value="<?php
                                                                                                                   $db_conn = SqlManager::getInstance();
                                                                                                                   $sql = " SELECT * FROM places JOIN garage_sales_places ON places.place_id=garage_sales_places.place_fk_id WHERE garage_sales_places.garage_sale_fk_id=? ; ";
                                                                                                                   $result = $db_conn->query($sql, array($gsale->getData()->gsale_id));
                                                                                                                   echo $result->getResult()[0]->street_number . " " . $result->getResult()[0]->route . ", " . $result->getResult()[0]->locality . ", " . $result->getResult()[0]->administrative_area_level_1;
                                                                                                                   ?>" placeholder="Enter location of sale">
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12">
          <div class="form-group">
            <label for="description">General Description:</label>
            <textarea class="form-control" rows="4" cols="50" id="description" name="description" placeholder="Enter a description of the types of item for sale"><?php echo $gsale->getData()->description; ?></textarea>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-6">
          <h3>Items:</h3>
        </div>
        <div class="col-sm-3 pull-right">
          <a style="margin-top:20px;margin-bottom:10px" href="createItem.php?gsale_id=<?php echo $gsale->getData()->gsale_id ?>" class="btn btn-green form-control" id="add_date">Add Item&nbsp;<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
          </a>
        </div>
      </div>
      <!-- items -->
      <!--Validate input for items-->
      <?php
  $db_conn = SqlManager::getInstance();
             $sql = "SELECT * FROM items JOIN garage_sales_items ON items.item_id = garage_sales_items.item_fk_id WHERE garage_sales_items.gsale_fk_id = ?;";
             $result = $db_conn->query($sql, array($gsale->getData()->gsale_id));
             $item_data = $result->getResult();
             $count = count($item_data);
             $html = '';
             if ($count > 0) {
               for ($i = 0; $i < $count; $i++) {
                 $html .= '
               <input type="hidden" name="item_id[]" value="' . $item_data[$i]->item_id . '">
      <div class="row">
        <div class="col-sm-3">
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                <img src="' . (!empty($item_data[$i]->image_url) ? "{$item_data[$i]->image_url}" : "https://dummyimage.com/200x200/333/fff.png&text=No+image+uploaded") . '" alt="Picture of item for sale" style="width:100%;">
                <label for="image">Change image:</label>
                <input type="file" id="image1" name="image[]">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                <label for="sel1">Availabity:</label>
                <select class="form-control" id="select1" name="available[]">
                  <option value="default">--</option>
                  <option value="sold" ' . ($item_data[$i]->is_sold == 1 ? "selected"  : "") . '>Sold</option>
                  <option value="available" ' . ($item_data[$i]->is_sold == 0 ? "selected"  : "") . '>Available</option>
                </select>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-9">
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                <label for="price1">Price:</label>
                <input class="form-control" type="text" name="price[]" id="price1" placeholder="xx.xx" value="' . $item_data[$i]->price . '">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                <label for="select">Change catagory:</label>
                <select class="form-control" name="catagory[]" id="catagory">
                  <option value="default">---</option>
                  <option value="clothes" ' . (strcmp(explode(',', $item_data[$i]->keywords)[0], "clothes") === 0 ? "selected"  : "") . '>Clothes</option>
                  <option value="electronic" ' . (strcmp(explode(',', $item_data[$i]->keywords)[0], "electronic") === 0 ? "selected"  : "") . '>Electronics</option>
                  <option value="furnture" ' . (strcmp(explode(',', $item_data[$i]->keywords)[0], "furnture") === 0 ? "selected"  : "") . '>Furnture</option>
                  <option value="media" ' . (strcmp(explode(',', $item_data[$i]->keywords)[0], "media") === 0 ? "selected"  : "") . '>Media eg.(Books, Magazines, Music, Movies)</option>
                  <option value="tool" ' . (strcmp(explode(',', $item_data[$i]->keywords)[0], "tool") === 0 ? "selected"  : "") . '>Tools</option>
                  <option value="toy" ' . (strcmp(explode(',', $item_data[$i]->keywords)[0], "toy") === 0 ? "selected"  : "") . '>Toys</option>
                  <option value="vehicle" ' . (strcmp(explode(',', $item_data[$i]->keywords)[0], "vehicle") === 0 ? "selected"  : "") . '>Vehicle</option>
                  <option value="other" ' . (strcmp(explode(',', $item_data[$i]->keywords)[0], "other") === 0 ? "selected"  : "") . '>Other</option>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                <label for="description">General Description:</label>
                <textarea class="form-control" rows="5" cols="50" id="description" name="itemDescription[]" placeholder="Enter a description of the item for sale">' . $item_data[$i]->description . '</textarea>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-4 pull-right">
              <div class="form-group">
                <button class="btn btn-danger form-control" type="button" id="delete1" data-toggle="modal" data-target="#deleteModal' . ($i+1) . '" name="delete1">Delete Item&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span></button>
              </div>
            </div>
          </div>
        </div>
      </div>';
                 $html .= '
      <!-- Modal -->
      <div class="modal fade" id="deleteModal' . ($i+1) . '" role="dialog">
        <div class="modal-dialog">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">×</button>
              <h4 class="modal-title"><span class="glyphicon glyphicon-alert" aria-hidden="true"></span>&nbsp;Warning</h4>
            </div>
            <div class="modal-body">
              <p>You are about to delete an item from your sale are you sure you want to do that?</p>
            </div>
            <div class="modal-footer">
              <a type="button" class="btn btn-danger pull-left" href="?action=delete&amp;gsale_id=' . $item_data[$i]->gsale_fk_id . '&amp;item_id=' . $item_data[$i]->item_id . '">Delete Item</a>
              <a type="button" class="btn btn-default" data-dismiss="modal">Cancel</a>
            </div>
          </div>
        </div>
      </div><br><br>';
               }
             } else {
               $html .= '<div class="row"><div class="well"><p>No items created yet!</p></div></div>';
             }
             $html .= '
           <input type="hidden" name="gsale_id" value="' . $_GET['gsale_id'] . '">
           <input type="hidden" name="token" value="' . Token::generate() . '">
      <div class="row">
        <div class="col-sm-3 pull-right">
          <div class="form-group">
            <a class="btn btn-warning form-control" href="yourSales.php">Cancel</a>
          </div>
        </div>
        <div class="col-sm-3 pull-left">
          <div class="form-group">
            <input type="submit" id="submit" name="edit_submit" value="Save changes" class="btn btn-green form-control">
          </div>
        </div>
      </div>
    </form>
    </div>';
             echo $html;
             //var_dump($item_data);
      ?>
        <br>
        <br>

  </div>
