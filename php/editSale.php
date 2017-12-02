<?php
echo "edit";
//var_dump($gsale);
var_dump($gsale->getData()->sale_name);
// FIXME: check to see if user own sale before displaying page
?>
<div class="container">
  <form action="<?php $_SERVER['PHP_SELF'] ?>">
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
              <input type="file" id="image" name="image">
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
          <div class="row">
            <div class="col-sm-3">
              <input class="form-control" type="text" id="date1" name="date[]" placeholder="mm/dd/yyyy" value="<?php echo(isset($gsale) ? $gsale->getData()->sale_name : ''); ?>">
            </div>
            <div class="col-sm-3">
              <input class="form-control" type="time" id="startTime1" name="startTime[]">
            </div>
            <div class="col-sm-3">
              <input class="form-control" type="time" id="endTime1" name="endTime[]">
            </div>
            <div class="col-sm-3">
              <button type="button" class="btn btn-green-no-padding form-control" id="add_date" onclick="addDate()">Add Day&nbsp;<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
              </button>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12">
            <div class="form-group">
              <label for="phone">Phone:</label>
              <input type="phone" class="form-control" id="phone" name="phone" placeholder="(XXX)-XXX-XXXX" onkeypress="phoneFormat()" value="" maxlength="16">
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <div id="locationField" class="form-group">
          <label for="location">Location:</label>
          <input type="location" class="form-control" id="location" onfocus="geolocate()" name="location" value="" placeholder="Enter location of sale">
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <div class="form-group">
          <label for="description">General Description:</label>
          <textarea class="form-control" rows="4" cols="50" id="description" name="description" placeholder="Enter a description of the types of item for sale"></textarea>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-6">
        <h3>Items:</h3>
      </div>
      <div class="col-sm-3 pull-right">
        <a style="margin-top:20px;margin-bottom:10px" href="createItem.php?gsale_id=" class="btn btn-green form-control" id="add_date">Add Item&nbsp;<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
        </a>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-3">
        <div class="row">
          <div class="col-sm-12">
            <div class="form-group">
              <img src="https://dummyimage.com/200x200/333/fff.png&text=No+image+uploaded" alt="Picture of item for sale" style="width:100%;">
              <label for="image">Change image:</label>
              <input type="file" id="image1" name="item[]">
            </div>
          </div>
        </div>
        <!-- NOTE: should i get rid of Is sold label and make select show color of selected  -->
        <div class="row">
          <div class="col-sm-12">
            <div class="form-group">
              <label for="sel1">Change availabity:</label>
              <select class="form-control" id="select1" name="available[]">
                <option value="default">--</option>
                <option value="sold">Sold</option>
                <option value="available">Available</option>
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
              <input class="form-control" type="text" name="price[]" id="price1" placeholder="xx.xx">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12">
            <div class="form-group">
              <label for="select">Change catagory:</label>
              <select class="form-control" name="catagory[]" id="catagory">
                <option value="default">---</option>
                <option value="all" <?php  if (isset($_POST['catagory'])) {(strcmp(sanitizeInput($_POST['catagory']), 'all') ==0? 'selected' : '');} ?>>All Catagories</option>
                <option value="clothes" <?php if (isset($_POST['catagory'])) {(strcmp(sanitizeInput($_POST['catagory']), 'clothes') ==0? 'selected' : '');} ?>>Clothes</option>
                <option value="electronic" <?php if (isset($_POST['catagory'])) {(strcmp(sanitizeInput($_POST['catagory']), 'electronic') ==0? 'selected' : ''); }?>>Electronics</option>
                <option value="furnture" <?php if (isset($_POST['catagory'])) { (strcmp(sanitizeInput($_POST['catagory']), 'furnture') ==0? 'selected' : '');} ?>>Furnture</option>
                <option value="media" <?php if (isset($_POST['catagory'])) { (strcmp(sanitizeInput($_POST['catagory']), 'media') ==0? 'selected' : '');} ?>>Media eg.(Books, Magazines, Music, Movies)</option>
                <option value="tool" <?php if (isset($_POST['catagory'])) { (strcmp(sanitizeInput($_POST['catagory']), 'tool') ==0? 'selected' : '');} ?>>Tools</option>
                <option value="toy" <?php if (isset($_POST['catagory'])) { (strcmp(sanitizeInput($_POST['catagory']), 'toy') ==0? 'selected' : '');} ?>>Toys</option>
                <option value="vehicle" <?php if (isset($_POST['catagory'])) { (strcmp(sanitizeInput($_POST['catagory']), 'vehicle') ==0? 'selected' : '');} ?>>Vehicle</option>
                <option value="other" <?php if (isset($_POST['catagory'])) { (strcmp(sanitizeInput($_POST['catagory']), 'other') ==0? 'selected' : '');} ?>>Other</option>
              </select>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12">
            <div class="form-group">
              <label for="description">General Description:</label>
              <textarea class="form-control" rows="4" cols="50" id="description" name="itemDescription[]" placeholder="Enter a description of the item for sale"></textarea>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-4 pull-right">
            <div class="form-group">
              <button class="btn btn-danger form-control" type="button" id="delete1" data-toggle="modal" data-target="#deleteModal1" name="delete1">Delete Item&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span></button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <br>
    <br>
    <div class="row">
      <div class="col-sm-3 pull-right">
        <div class="form-group">
          <a class="btn btn-warning form-control" href="yourSales.php">Cancel</a>
        </div>
      </div>
      <div class="col-sm-3 pull-left">
        <div class="form-group">
          <input type="submit" id="submit" name="submit" value="Save changes" class="btn btn-green form-control">
        </div>
      </div>
    </div>
  </form>
  <!-- Modal -->
  <div class="modal fade" id="deleteModal1" role="dialog">
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
          <a type="button" class="btn btn-danger pull-left" href="?action=delete&amp;item_id=1">Delete Item</a>
          <a type="button" class="btn btn-default" data-dismiss="modal">Cancel</a>
        </div>
      </div>
    </div>
  </div>
</div>
