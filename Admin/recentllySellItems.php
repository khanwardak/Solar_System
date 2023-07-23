<?php
include('DBConnection.php');
if(isset($_GET["search_term"])){
   $search_term = $_GET['search_term'];
 
   
     $sql = "SELECT customers_bys_goods.person_id,customers_bys_goods.categ_id,customers_bys_goods.price,customers_bys_goods.quantity,customers_bys_goods.buy_date,category.categ_name,category.categ_id, person.person_id,person.person_name 
     FROM customers_bys_goods,category,person 
     WHERE person.person_id = customers_bys_goods.person_id
    AND person.person_name ='$search_term'";
     include('DBConnection.php');
     $result = $conn->query($sql);
     if ($result->num_rows > 0) {
       while ($row = $result->fetch_assoc()) {
   
         echo ' <tr class="">
                        <td>' . $row["categ_name"] . '</td>
   
                        <td> ' . $row["price"] . '</td>
                        <td>' . $row["buy_date"] . '</td>
                        <td><a href="admin.php?customer=' . $row["person_name"] . '"style="color:#fff" >' . $row["person_name"] . '</a></td>
                        <td>
                        <ul class="action-list" style="color:#fff">
                            <li><a href="#" data-tip="edit"><i class="fa fa-edit"></i></a></li>
                            <li><a href="#" data-tip="delete"><i class="fa fa-trash"></i></a></li>
                        </ul>
                    </td>
                    </tr>';
       }
     }
     else{
        echo "the user not found";
     }
   
   
}
?>