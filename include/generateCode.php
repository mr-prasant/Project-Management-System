<?php

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

          let TID = 'TID' + year + month + day + hour + mins + secs + ms;
          document.cookie = 'pms_new_TID='+ TID;
      </script>";

?>