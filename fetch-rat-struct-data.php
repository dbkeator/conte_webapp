<?php
  require_once $_SERVER['DOCUMENT_ROOT'] . '/lib/rdf-db.php';
  require_once $_SERVER['DOCUMENT_ROOT'] . '/lib/misc.php';

  //the "yes" flag specifies that the term should have hyperlinks to source URL
 // $terms = get_conte_terms_hash("yes");

  $animal = $_REQUEST['animal'];
  $acq = $_REQUEST['acq'];
  $region = $_REQUEST['region'];
  $comp = $_REQUEST['comp'];
  $std = $_REQUEST['std'];
  $download = $_REQUEST['dl'];

  $arr = get_rat_struct_data($animal, $acq, $region, $comp, $std);
  $data = $arr['data'];
  $query = $arr['query'];
  $query = str_replace("<", "&lt", $query);
  $query = str_replace(">", "&gt", $query);
?>
  <div style="float:right;">Toggle SPARQL Query <input style="vertical-align:middle;" type="checkbox" id="toggle_switch" onclick="toggleSPARQL();" /> </div>
  <br />
  <div id='sparql_query' style='display:none;'><pre><?php echo $query; ?></pre> </div>
<?php
  $numrows = count($data);

  //echo '<span class="tooltiptet">'.$terms['heartRateAvg'].'</span>';
  if ($animal == '*'){
    $animal = 'all';
  }
  if ($acq == '*' || $acq == 'undefined'){
    $acq = 'all';
  }
  if ($region == '*'){
    $region = 'all';
  }

  $link = '';
  if ($download == 'yes'){
    $time = time();
    $filename = "rat-struct-".$animal."-".$acq."-".$region;
    if ($comp != '*'){
      $filename .= "-".$comp."-".$std;
    }
    $filename .= "-".$time.".csv";
    $link = save_rat_struct_csv_file($filename,$data);
  }

  echo "Rat structure data for animal:<strong>" . $animal . "</strong> acquisition:<strong>" . $acq . "</strong>  brain region:<strong>" . $region . "</strong> ";
  if ($comp != '*'){
    echo "view data:<strong>" . $comp . "</strong> than sample by standard deviation:<strong>" . $std."</strong>";
  }
  echo "<br />";
  echo "$numrows entries found.";
  if ($download == 'yes'){
    echo "<br />$link";
  }
  echo '<div style="max-height: 400px; overflow-y: auto; clear: both;">';
  echo '<table class="gridtable">';
  echo '<tr>';
  //echo '<tr><th title="' . $terms['mother'] . '">Mother</th>';
  echo '<th>Animal</th>';
  echo '<th>Acquisition</th>';
  echo '<th>Region</th>';
  echo '<th>Slice</th>';
  echo '<th>Average intensity</th>';
  echo '<th>Standard deviation</th>';
  echo '<th>Max</th>';
  echo '<th>Min</th>';
  echo '<th>Pixel area</th>';
  echo '<th>Pixel sum</th>';
  echo '<th>ROI file</th>';
  echo '</tr>';
  for($ri = 0; $ri < $numrows; $ri++) {
    echo '<tr>';
    $row = $data[$ri];
    echo "<td>".$row['animal']."</td>";
    echo "<td>".$row['acq']."</td>";
    echo "<td>".$row['region']."</td>";
    echo "<td>".$row['slice']."</td>";
    echo "<td>".round($row['avg'],4)."</td>";
    echo "<td>".round($row['std'],4)."</td>";
    echo "<td>".round($row['max'],4)."</td>";
    echo "<td>".round($row['min'],4)."</td>";
    echo "<td>".$row['area']."</td>";
    echo "<td>".$row['sum']."</td>";
    echo "<td>".$row['file']."</td>";
    //echo "<td>".$row['fetus']."</td>";
    //echo "<td>".round($row['heartRate'],2)."</td>";
    //echo "<td>".round($row['heartRateStd'],2)."</td>";
    echo '</tr>';
  }
  echo "</table>";
  echo "</div>";
?>

