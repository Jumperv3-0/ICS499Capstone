<?php
$gsale_data = $gsale->getData();
// TODO preven people from getting to this page
?>
<div class="container">
  <div class="well">
    <div class="row">
      <h3 class="text-center"><?php echo $gsale_data->sale_name ?></h3>
    </div>
    <div class="row">
      <div class="col-sm-3">
        <img src="../uploads/<?php echo $gsale_data->image_url ?>" alt="Garage sale photo">
      </div>
      <div class="col-sm-8">
        <?php
        $times = DateTimeFormater::getTimes($gsale_data->dates);
        $dates = DateTimeFormater::getDays($gsale_data->dates);
        $count = count($times);
        $size = ($count > 4)? "2" : "3";
        $html = '<div class="row">';
        for ($i = 0; $i < $count; $i++) {
          if ($i == 0) {
            $html .= '<div class="col-sm-'. $size .'"><h3 style="margin-top:0;">Dates:</h3><div>' . $dates[$i] .  '</div><div>' . $times[$i] . '</div></div>';
          } else {
            $html .= '<div class="col-sm-'. $size .'"><h3 style="margin-top:0;">&nbsp;</h3><div>' . $dates[$i] .  '</div><div>' . $times[$i] . '</div></div>';
          }
        }
        echo $html;
        ?>
      </div>
      <div class="col-sm-8" style="padding-left:0;">
        <h3>Phone:</h3>
        <div>
          <?php
          $db_conn = SqlManager::getInstance();
          $sql = "SELECT phone_number FROM phones JOIN garage_sales_phones ON phones.phone_id = garage_sales_phones.phone_fk_id WHERE garage_sales_phones.garage_sale_fk_id = ?;";
          $result = $db_conn->query($sql, array($gsale_data->gsale_id));
          echo $result->getResult()[0]->phone_number;
          ?>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-3">
      <h3>Location:</h3>
      <p>
        <?php
        $db_conn = SqlManager::getInstance();
        $sql = "SELECT * FROM places JOIN garage_sales_places ON places.place_id = garage_sales_places.place_fk_id WHERE garage_sales_places.garage_sale_fk_id = ?;";
        $result = $db_conn->query($sql, array($gsale_data->gsale_id));
        echo $result->getResult()[0]->street_number . " " . $result->getResult()[0]->route . ", " . $result->getResult()[0]->locality . ", " . $result->getResult()[0]->administrative_area_level_1;
        ?>
      </p>
    </div>

    <div class="col-sm-6">
      <h3>Description:</h3>
      <p>
        <?php
        echo $gsale_data->description;
        ?>
      </p>
    </div>
    <div class="col-sm-2">
      <h3>&nbsp;</h3>
      <a class="btn btn-green-no-padding" href="?gsale_id=<?php echo $gsale_data->gsale_id ?>&directions=true">Show Directions<i class="material-icons">directions</i></a>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-12">
      <h3>Items:</h3>
    </div>
  </div>
  <?php
    $db_conn = SqlManager::getInstance();
    $sql = "SELECT * FROM items JOIN garage_sales_items ON items.item_id = garage_sales_items.item_fk_id WHERE garage_sales_items.gsale_fk_id = ?;";
    $result = $db_conn->query($sql, array($gsale_data->gsale_id));
    $item_data = $result->getResult();
    $count = count($item_data);
    $html = '';
    for ($i = 0; $i < $count; $i++) {
      $html .= '
      <div class="row">
        <div class="col-sm-3">
          <img src="../uploads/' . $item_data[$i]->image_url . '" alt="Picture of item for sale">
        </div>
        <div class="col-sm-2">
          <h3>Price:</h3>
          <p>' . $item_data[$i]->price . '</p>
        </div>
        <div class="col-sm-7">
          <h3>Description:</h3>
          <p>' . $item_data[$i]->description . '</p>
        </div>
      </div>';
    }
    $html .= '</div><div class="row"><h3></h3></div>';
         echo $html;
    //var_dump($item_data);
  ?>
</div>
