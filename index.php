<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Project Management</title>
  <link rel="stylesheet" href="./css/style.css">
  <link rel="stylesheet" href="./css/input.css">
  <?php require_once "./include/links.php" ?>
</head>

<body>
  <?php require "./include/db.php" ?>
  <!-- navbar -->
  <?php require_once "./include/nav.php" ?>

  <div class="main-container">
    <?php
    $query1 = "select * from users order by UID desc;";
    $data1 = mysqli_query($con, $query1);

    $query2 = "select * from tasks order by TID desc;";
    $data2 = mysqli_query($con, $query2);

    $add_user_click = false;
    if (isset($_POST["add-user-btn"])) {
      $new_username = $_POST['new-username'];
      $add_user_click = true;
      if ($new_username != "" && $add_user_click) {
        echo "<script>
          const date = new Date();
          let year = date.getFullYear();
          let month = formatData(date.getMonth() + 1);
          let day = formatData(date.getDate());
          let hour = formatData(date.getHours());
          let mins = formatData(date.getMinutes());
          let secs = formatData(date.getSeconds());
          let ms = formatMillisecond(date.getMilliseconds());
          
          function formatData(num) {
            return num < 10 ? '0' + num : num + '';
          }
          
          function formatMillisecond(num) {
            if (num < 10) return '00' + num;
            if (num < 100) return '0' + num;
            return num + '';
          }
          
          let UID = 'UID' + year + month + day + hour + mins + secs + ms;
          document.cookie = 'pms_new_UID='+ UID;
      </script>";

        $new_UID = $_COOKIE['pms_new_UID'];

        try {
          $query = "insert into users values('" . $new_UID . "', '" . $new_username . "');";
          $execute = mysqli_query($con, $query);

          if ($execute) {
            echo "<script>
                alert('" . $new_UID . ": " . $new_username . " has been added');
                window.open('index', '_self');
              </script>";
          } else {
            echo "<script>
                alert('Something went wrong!\n" . $new_username . " is not added, please try again!');
              </script>";
          }
        } catch (Exception $ex) {
        }
      }
    }

    $delete_user_btn_click = false;
    if (isset($_POST['delete-user-btn'])) {
      $delete_user_btn_click = true;
      $selected_user = $_COOKIE['PMS_user'];
      if ($selected_user != "Invalid" && $selected_user != "" && $delete_user_btn_click) {
        try {
          $query1 = "delete from users where UID = '" . $selected_user . "';";
          $query2 = "delete from posts where UID = '" . $selected_user . "';";

          $execute1 = mysqli_query($con, $query1);
          $execute2 = mysqli_query($con, $query2);

          if ($execute1 || $execute2) {
            echo "<script>
                alert('User removed successfully!');
                window.open('index', '_self');
              </script>";
          }
        } catch (Exception $ex) {
        }
      }
    }

    $add_task_btn_click = false;
    if (isset($_POST['add-task-btn'])) {
      $add_task_btn_click = true;
      $new_task = $_POST['task-desc'];
      $selected_user = $_COOKIE['PMS_user'];
      $status = "In progress";

      if ($new_task != "" && $add_task_btn_click && $selected_user != "Invalid" && $selected_user != "") {
        echo "<script>
        const date = new Date();
        let year = date.getFullYear();
        let month = formatData(date.getMonth() + 1);
        let day = formatData(date.getDate());
        let hour = formatData(date.getHours());
        let mins = formatData(date.getMinutes());
        let secs = formatData(date.getSeconds());
        let ms = formatMillisecond(date.getMilliseconds());
        
        function formatData(num) {
          return num < 10 ? '0' + num : num + '';
        }
        
        function formatMillisecond(num) {
          if (num < 10) return '00' + num;
          if (num < 100) return '0' + num;
          return num + '';
        }
        
        let TID = 'TID' + year + month + day + hour + mins + secs + ms;
        document.cookie = 'pms_new_TID='+ TID;
      </script>";

        $new_TID = $_COOKIE['pms_new_TID'];
        $user = "";
        try {
          $query = 'select username from users where UID = "' . $selected_user . '";';
          $data = mysqli_query($con, $query);

          if (!$data) {
            echo "No user selected!";
          } else {
            $row = mysqli_fetch_assoc($data);
            $user = $row['username'];
          }

          $query = "insert into tasks values('" . $new_TID . "', '" . $user . "', '" . $new_task . "', '" . $status . "', '" . $selected_user . "');";
          $execute = mysqli_query($con, $query);

          if ($execute) {
            echo "<script>
                alert('Task added successfully!');
                window.open('index', '_self');
              </script>";
          }
        } catch (Exception $ex) {
        }
      } else {
        echo "<script>
                alert('Ops, something wrong!');
              </script>";
      }
    }
    ?>
    <div class="side">
      <div class="title">
        PROJECT <span>MANAGEMENT</span>
      </div>
      <img src="./img/4661361.png" alt="">
    </div>
    <main>
      <div class="main-sub-container">
        <form action="?" method="post" enctype="multipart/form-data">
          <div class="add-user">
            <div class="add-user-title">New User</div>
            <input type="text" name="new-username" placeholder="Name" class="textfeild" id="new-user-name">
            <button type="submit" class="button blue" id="add_user_btn" name="add-user-btn">Add User</button>
          </div>
          <div class="operation">
            <div class="select">
              <select name="select-user" class="select-user" id="select-user" onchange="getSelectedUser()">
                <option selected disabled>Select user</option>
                <?php
                while ($row = mysqli_fetch_assoc($data1)) {
                  $username = $row["username"];
                  $UID = $row['UID']; ?>
                  <option value="<?php echo $UID ?>"><?php echo $username ?></option>
                  <?php
                }
                ?>
              </select>
            </div>
            <button type="submit" class="button red" id="delete-user-btn" name="delete-user-btn">Delete User</button>
          </div>
          <div class="add-task-section">
            <input type="text" class="textfeild" id="task-desc" name="task-desc" placeholder="Describe task">
            <button type="submit" class="button blue" id="add-task-btn" name="add-task-btn">Add Task</button>
          </div>
        </form>
      </div>
    </main>
  </div>
  <div class="result">
    <div class="result-container">
      <?php
      while ($row = mysqli_fetch_assoc($data2)) {
        $TID = $row['TID'];
        $username = $row['username'];
        $task = $row['task'];
        $status = $row['status']; ?>

        <ul class="task" id="<?php echo $TID ?>">
          <li>User:
            <?php echo $username ?>
          </li>
          <li>Task allocated:
            <?php echo $task ?>
          </li>
          <li>Status:
            <?php echo $status ?>
          </li>
          <li name="TID" class="hidden">
            <?php echo $TID ?>
          </li>
        </ul>
        <?php
      }
      ?>
    </div>
  </div>

  <!-- footer -->
  <?php require_once "./include/footer.php" ?>
</body>
<script src="./js/index.js"></script>
<script src="./js/feedback.js"></script>

</html>