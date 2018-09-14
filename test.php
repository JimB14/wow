<?php

include 'includes/dbconnect.php';

/*
// Build Main Navigation menu and gather page data here

$query = $db->query("SELECT * FROM pages);


$menuDisplay = '<ul>';
while($row = $query->fetch(PDO::FETCH_ASSOC)){
  $pid = $row["page_id"];
  $linklabel = $row["main_menu_name"];
  $menuDisplay .= '<li' . ($pid == $_GET["pid"] ? ' class="active"' : '') . '><a href="index.php?pid=' . $pid . '">' . $linklabel . '</a></li>';
}
mysqli_free_result($query);
$menuDisplay .= '</ul>';
*/    

// Build Main Navigation menu and gather page data here
$sql = "SELECT * FROM pages";
$query = $db->query($sql) or die (mysqli_error());
$menuDisplay = '<ul>';
while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
  $pid = $row["main_menu_id"];
  $linklabel = $row["main_menu_name"];
  $menuDisplay .= '<li' . ($pid == $_GET["pid"] ? ' class="selected"' : '') . '><a href="index.php?pid=' . $pid . '">' . $linklabel . '</a></li>';
}
mysqli_free_result($query);
$menuDisplay .= '</ul>';