<?php
echo "gegining";
var_dump($gsale);
var_dump($gsale->getData()->sale_name);
?>
<div class="container">
  <form action="<?php echo sanitizeInput($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
    <div class="form-group">
      <label for="sale_name">Name of sale:</label>
      <input type="text" class="form-control" id="sale_name" name="sale_name" value="<?php echo(isset($gsale) ? $gsale->getData()->sale_name : ''); ?>" placeholder="Enter name of sale">
    </div>
    <div class="form-group">
      <input type="file" id="image" name="image">
    </div>
    <div class="form-group">
      <label for="description">General Description:</label>
      <textarea class="form-control" rows="4" cols="50" id="description" name="description" placeholder="Enter a description of the types of item for sale"><?php echo(isset($gsale) ? $gsale->getData()->description : ''); ?></textarea>
    </div>
    <!--  TODO: get all dates and display -->
    <div id="date-time" class="form-group">
      <div class="row">
        <div class="col-sm-4">
          <label for="location1">Date:</label>
        </div>
        <div class="col-sm-3">
          <label for="startTime1">Start Time:</label>
        </div>
        <div class="col-sm-3">
          <label for="endTime1">End Time:</label>
        </div>
      </div>
      <div class="row">
        <div class="col-xs-12 col-sm-4 form-group">
          <input type="date" class="form-control" id="date1" name="date[]" value="">
        </div>
        <div class="col-xs-12 col-sm-3 form-group">
          <input type="time" class="form-control " id="startTime1" name="startTime[]" value="">
        </div>
        <div class="col-xs-12 col-sm-3 form-group">
          <input type="time" class="form-control" id="endTime1" name="endTime[]" value="">
        </div>
        <div class="col-xs-12 col-sm-2 form-group">
          <button type="button" class="btn btn-green-no-padding form-control" id="add_date" onclick="addDate()">Add Day <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
          </button>
        </div>
      </div>
    </div>
    <div id="locationField" class="form-group">
      <label for="location">Location:</label>
      <input type="location" class="form-control" id="location" onFocus="geolocate()" name="location" value="<?php echo(isset($_POST['location']) ? sanitizeInput($_POST['location']) : ''); ?>" placeholder="Enter location of sale">
    </div>
    <div class="form-group">
      <label for="phone">Phone:</label>
      <input type="phone" class="form-control" id="phone" name="phone" placeholder="(XXX)-XXX-XXXX" onkeypress="phoneFormat()" value="<?php echo(isset($_POST['phone']) ? sanitizeInput($_POST['phone']) : ''); ?>" maxlength="16">
    </div>
    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
    <div class="row">
      <div class="col-xs-12 col-sm-2 pull-right">
        <button type="submit" class="btn btn-green-no-padding form-control pull-right" name="submit">Submit</button>
      </div>
    </div>
  </form>
</div>
