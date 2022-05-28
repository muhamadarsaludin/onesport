<?php

function my_info()
{
  if (logged_in()) {
    $usersModel = Model('UsersModel');
    $user = $usersModel->getUserById(user_id())->getRow();
    return $user;
  }
}

function venue()
{
  if (logged_in()) {
    $venueModel = Model('VenueModel');
    $venue = $venueModel->getWhere(['user_id' => user_id()])->getRow();
    if ($venue) {
      return $venue;
    }
    return false;
  }
}

function notif()
{
  if (logged_in()) {
    $notificationModel = Model('NotificationModel');
    $notif = $notificationModel->getTheLatestNotifications(user()->id)->getResultArray();
    if ($notif) {
      return $notif;
    }
    return false;
  }
}
