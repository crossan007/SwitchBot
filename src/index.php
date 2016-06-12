<?php 

include "Include/config.php";

?>

<!DOCTYPE html>
<html lang="en">

  <head>
    <title>FCC Systems Controller</title>
   <?php include "Include/header.php"; ?>
  </head>
  <body>
    <div class="container">
      <div class="header">
        <nav>
          <ul class="nav nav-pills pull-right">
            <li class="active" ><a data-toggle="pill" href="#presets">System Presets</a></li>
            <li ><a data-toggle="pill" href="#components">Component Controls</a></li>
            <li ><a data-toggle="pill" href="#settings">Settings</a></li>
            <li ><a data-toggle="pill" href="#status">Status Report</a></li>
          </ul>
        </nav>
        <h3 class="text-muted">FCC Systems Controller</h3>
      </div>

      <div class="tab-content">
        <div id="presets" class="tab-pane fade in active">
          <h3>System Presets</h3>
          <p class="lead"></p>
          <p><a class="btn btn-lg btn-success" data-toggle="modal" data-target="#confirm-shutdown" role="button">Off</a></p>
          <p><a class="btn btn-lg btn-success presetButton" href="#" id="practice" role="button">Worship Practice / Warm Up</a></p>
          <p><a class="btn btn-lg btn-success presetButton" href="#" id="dvd" role="button">Watch a DVD</a></p>
          <p><a class="btn btn-lg btn-success presetButton" href="#" id="sundayservice" role="button">Sunday Service</a></p>
          <p><a class="btn btn-lg btn-success presetButton" href="#" id="speaker" role="button">Guest Speaker</a></p>
        </div>

       <div id="components" class="tab-pane fade">
          <h3>Component Controls</h3>
          {% for ControlObject in ControlObjects %}
          {% include "ControlObject.html" %}
          {% endfor %}
        </div>
        <div id="settings" class="tab-pane fade">
          <h3>Settings</h3>

        </div>
        <div id="status" class="tab-pane fade">
          <h3>Status</h3>

        </div>

      </div>

      <hr>

      <div>
        <h4>Recording Controls</h4>
        <div class="btn-group" data-toggle="buttons">
          <label class="btn btn-primary active">
            <input type="radio" name="Projector" id="option1" autocomplete="off" checked> Recording Stopped
          </label>
          <label class="btn btn-primary">
            <input type="radio" name="Projector" id="option2" autocomplete="off"> Recording Started
          </label>
        </div> 

      </div>

    <?php include "Include/footer.php"; ?>

    </div>
     
  </body>

</html>