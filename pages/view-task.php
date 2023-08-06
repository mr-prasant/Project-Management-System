<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Project Management | task</title>
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="../css/input.css">
  <link rel="stylesheet" href="../css/view.css">
  <script src="https://kit.fontawesome.com/5099b17d5e.js" crossorigin="anonymous"></script>
  <script src="https://smtpjs.com/v3/smtp.js"></script>
</head>

<body>
  <?php require_once "../include/db.php" ?>
  <!-- navbar -->
  <?php require_once "../include/nav.php" ?>

  <header>
    <?php
    $TID = $_COOKIE['PMS_tid'];
    echo "<script>
          console.log('" . $TID . "');
          const searchParams = new URLSearchParams(window.location.search);
          searchParams.set('', '" . $TID . "');
          const newPath = window.location.pathname + '?' + searchParams.toString();
          history.pushState(null, '', newPath);
        </script>";

    if (isset($_POST["save-btn"])) {
      $new_status = "";
      try {
        $new_status = $_POST['complete'];
      } catch (Exception $ex) {
        $new_status = "In progress";
      }

      $new_task = $_POST['task-view'];

      if (strlen($new_task) > 0) {
        try {
          $query = "update tasks set task = '" . $new_task . "', status = '" . $new_status . "' where TID = '" . $TID . "';";
          $execute = mysqli_query($con, $query);

          if ($execute) {
            echo "<script>
                    alert('Task updated successfully!');
                    window.open('../index.php', '_self');
                  </script>";
          } else {
            echo "<script>
                    alert('Task not updated!');
                  </script>";
          }
        } catch (Exception $e) {
          echo "<script>
                    alert('Something wrong, please try again!');
                  </script>";
        }
      } else {
        echo '<script>
            alert("Please write a task");
            </script>';
      }
    }

    if (isset($_POST["delete-btn"])) {
      $query = "delete from tasks where TID='" . $TID . "';";
      $execute = mysqli_query($con, $query);

      if ($execute) {
        echo "<script>
                alert('Task deleted successfully!');
                window.open('../index.php', '_self');
              </script>";
      } else {
        echo "<script>
                alert('Task not deleted!');
              </script>";
      }
    }

    $query = "select * from tasks where tid = '" . $TID . "'";
    $result = mysqli_query($con, $query);

    if (!$result) {
      echo "could not find!";
    } else {
      $row = mysqli_fetch_assoc($result);
      $username = $row['username'];
      $task = $row['task'];
      $status = $row['status'];
      $UID = $row['UID'];
    }

    echo "<script>
          document.cookie = 'PMS_status=" . $status . "';
        </script>";
    ?>
    <div class="main-view-container">
      <form action="?" method="post" enctype="multipart/form-data">
        <div class="user-name text">
          User:
          <?php echo $username ?>
        </div>
        <div class="user-id text">
          User ID: <span class="id">
            <?php echo $UID ?>
          </span>
        </div>
        <div class="user-task">
          <div class="task-title text">Task ID: <span class="id">
              <?php echo $TID ?>
            </span> </div>
          <input type="text" name="task-view" class="textfeild" id="task-view" value="<?php echo $task ?>"
            placeholder="Task">
        </div>
        <div class="check-container">

          <?php $check = ($status == 'Completed') ? "checked" : "" ?>
          <input type="hidden" id="complete" name="complete" value="In progress">
          <input type="checkbox" name="complete" id="complete" value="Completed" <?php echo $check ?>>
          <label for="complete" class="text">Completed?</label>
        </div>
        <div class="btn-container">
          <button type="submit" class="button green" id="save-btn" name="save-btn">Save</button>
          <button type="submit" class="button red" id="delete-btn" name="delete-btn">Delete Task</button>
        </div>
      </form>
      <button type="submit" class="button blue" id="back-btn" name="back-btn">Back</button>
    </div>
  </header>

  <!-- footer -->
  <footer id="footer">
    <div id="slideContainer">
      <div id="slide1">
        <div id="desc">
          <div id="title">PMS (Project Management System)</div>
          <div id="details">
            Project Management System in PHP is a platform from which employees and managers can use for collaboration
            and communication.
          </div>
        </div>
        <div id="socialBtnContainer">
          <a href="https://www.facebook.com/prasant.chandrapoddar?mibextid=ZbWKwL"><i
              class="fa-brands fa-square-facebook"></i></a>
          <a href="https://www.instagram.com/prasant.cp"><i class="fa-brands fa-instagram"></i></a>
          <a href="https://www.linkedin.com/in/prasantcp"><i class="fa-brands fa-linkedin"></i></a>
        </div>
        <div id="feedbackBtnContainer">
          <button type="submit" id="feedbackBtn">Share your feedback!</button>
        </div>
      </div>

      <div id="slide2">
        <div id="feedbackFormContainer">
          <button id="feedbackBackBtn">
            <i class="fa-solid fa-backward"></i>
          </button>
          <div id="feedback">
            <div id="title">Write your Feedback!</div>
            <textarea id="feedbackContent" placeholder="Write here..."></textarea>
            <button id="shareFeedback" type="submit">Share</button>
          </div>
        </div>
      </div>
    </div>
    <div id="developed">developed by @prasant</div>
  </footer>
</body>
<script src="../js/view.js"></script>
<script src="../js/feedback.js"></script>

</html>