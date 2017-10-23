<?php
 require_once 'init.php'; require_once 'Objects.php';
  // TODO: change page access to when only logged in
?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <title>
      <?php PageBuilder::getTitle() ?>
    </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
  </head>

  <body>
    <header>
      <?php
        $pageBuilder = new IndexPage();
        $pageBuilder->getHeader();
      ?>
    </header>
    <div class="container">
      <h1>Create Sale</h1>
      <form action="<?php echo sanitizeInput($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
        <div class="form-group">
          <label for="sale_name">Name of sale:</label>
          <input type="text" class="form-control" id="sale_name" name="sale_name" value="<?php echo (isset($_POST['sale_name']) ? sanitizeInput($_POST['sale_name']) : " "); ?>">
        </div>
        <div class="form-group">
          <l </div>
            <div class="form-group">
              <input type="file" id="image" name="image">
            </div>
            <div class="form-group">
              <label for="description">General Description:</label>
              <textarea class="form-control" rows="4" cols="50" id="description" name="description"></textarea>
            </div>
            <div class="form-group">
              <label for="start_date">Start Date:</label>
              <div class="form-group">
                <div class='input-group date' id='datetimepicker1'>
                  <input type='text' class="form-control" />
                  <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                  </span>
                </div>
              </div>
            </div>
            <script type="text/javascript">
              $(function() {
                $('#datetimepicker1').datetimepicker();
              });

            </script>
            <input type="date" class="form-control" id="start_date" name="start_date" value="<?php echo (isset($_POST['start_date']) ? sanitizeInput($_POST['start_date']) : " "); ?>">
        </div>
        <div class="form-group">
          <label for="end_date">End Date:</label>
          <input type="text" class="form-control" id="end_date" name="end_date" value="<?php echo (isset($_POST['end_date']) ? sanitizeInput($_POST['end_date']) : " "); ?>">
        </div>
        <div class="form-group">
          <label for="location">Location:</label>
          <input type="location" class="form-control" id="location" name="location" value="<?php echo (isset($_POST['location']) ? sanitizeInput($_POST['location']) : " "); ?>">
        </div>
        <div class="form-group">
          <label for="phone">Phone:</label>
          <input type="phone" class="form-control" id="phone" name="phone" value="<?php echo (isset($_POST['phone']) ? sanitizeInput($_POST['phone']) : " "); ?>">
        </div>
        <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
        <button type="submit" class="btn btn-default" name="submit">Submit</button>
      </form>
    </div>
    <footer>
      <?php
      PageBuilder::getFooter();
    ?>
    </footer>
  </body>

  </html>
