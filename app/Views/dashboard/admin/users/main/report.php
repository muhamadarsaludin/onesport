<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $title . ' ~ Printed by ' . @my_info()->username ?></title>
  <style>
    * {
      font-family: sans-serif;
    }

    table {
      width: 100%;
    }

    table,
    th,
    tr,
    td {
      border: 1px solid black;
      border-collapse: collapse;
      border-spacing: 0;
    }

    th,
    td {
      padding: 18px;
    }

    .text-center {
      text-align: center;
    }

    .text-right {
      text-align: right;
    }

    .m-fix {
      margin: 15px;
    }

    .mt-fix {
      margin-top: 15px;
    }

    .mb-fix {
      margin-bottom: 15px;
    }

    hr {
      width: 100%;
      margin-bottom: 30px;
    }
  </style>
</head>

<body>
  <h1 class="text-center"><?= $title ?></h1>
  <hr>
  <table>
    <tr>
      <th>No.</th>
      <th>Username</th>
      <th>Email</th>
      <th>Role</th>
      <th>Status</th>
    </tr>
    <?php
    $i = 1;
    foreach ($users as $row) :
    ?>
      <tr class="text-center">
        <td><?= $i++ ?></td>
        <td><?= $row->username ?></td>
        <td><?= $row->email ?></td>
        <td><?= $row->role_name ?></td>
        <td><?= ($row->active) ? 'Active' : 'Non-active' ?></td>
      </tr>
    <?php endforeach ?>
  </table>
</body>

</html>