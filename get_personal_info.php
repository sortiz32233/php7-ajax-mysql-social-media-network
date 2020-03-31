<?php 

include("connect.php");

  $id = $_SESSION['id'];
  $sql = "SELECT * FROM tbl_users WHERE id = :id";
  $statement = $connect->prepare($sql);
  $statement->bindValue(":id", $id);
  $statement->execute();
  $result = $statement->fetchAll();
  $output = '';
  
  foreach($result as $row){
  if ($row['relationship_status'] != '' || $row['relationship_status'] != null) {
    $output .= '<div class="d-flex flex-rows relationship-status">
  <i class="fas fa-heart text-danger" style="margin-top: .35rem"></i>
      &emsp;<div id="relationship_status">'.$row["relationship_status"].'</div>
  </div>';
  }

  if ($row['occupation'] != '' || $row['ocupation'] != null) {
    $output .= '<div class="d-flex flex-rows occupation">
    <i style="color:saddlebrown" class="fas fa-briefcase mt-2"></i>&ensp;<div id="occupation" contenteditable="false" class="editable-div">'.$row['occupation'].'</div>
    </div>';
  }

  
  if ($row['hometown'] != '' || $row['hometown'] != null) {
  $output .= '
  <div class="d-flex flex-rows hometown">
  <i class="fas fa-home text-dark mt-2"></i>&ensp;<div contenteditable="false" id="hometown" class="editable-div">'.$row['hometown'].'</div>
  </div>';
  }

  if ($row['alma_mater'] != '' || $row['alma_mater'] != null) {
  $output .= '
  <div class="d-flex flex-rows alma-mater">
<i style="color:darkblue" class="fas fa-graduation-cap mt-2"></i>&ensp;<div id="almaMater" contenteditable="false" class="editable-div">'.$row['alma_mater'].'</div>
</div>';
  }
  }

  echo $output;
  
?>