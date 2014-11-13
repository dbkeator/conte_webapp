<?php
  $db = $_SERVER['DOCUMENT_ROOT'] . '/lib/rdf-db.php';
  require_once $db;

  function get_conte_terms_hash($links = 'no'){
    $data = get_conte_terms();
    $numrows = count($data);

    $hash = array();
    for($ri = 0; $ri < $numrows; $ri++) {
      $row = $data[$ri];
      $term = $row['term'];

      $link = trim($row['prefTerm']);
      if (trim($row['url']) != '' && $links == 'yes'){
        $link = "<u><a href='".trim($row['url'])."' target='_blank'>".trim($row['prefTerm'])."</a></u>";
      }
      $desc = $link.": ".$row['definition'];
      $hash[$term] = $desc;
      //echo $row['term']."<br />".$desc ."<br /><br />";
    }

    return $hash;
  }

  function save_rat_dti_csv_file ($filename, $data){
    $file = $_SERVER['DOCUMENT_ROOT'] . "/temp/" . $filename;

    $content = "Animal number,Acquisition number,Scan type,Hemisphere,Slice,Average intensity,Standard deviation,Max,Min,Pixel area,Pixel sum,ROI file\n";
    $numrows = sizeof($data);
    for($ri = 0; $ri < $numrows; $ri++) {
      $row = $data[$ri];
      $content .= $row['animal'].",".$row['acq'].",".$row['scanType'].",".$row['hemi'].",".$row['slice'].",".round($row['avg'],4).",";
      $content .= round($row['std'],4).",".round($row['max'],4).",".round($row['min'],4).",".$row['area'].",".$row['sum'].",\"".$row['file']."\"\n";
    }

    file_put_contents($file, $content);
    $link = "Click <a href='/download.php?filename=".$filename."' download='".$filename."'>here</a> to download CSV data.";
    return $link;
  }

  function save_rat_struct_csv_file ($filename, $data){
    $file = $_SERVER['DOCUMENT_ROOT'] . "/temp/" . $filename;

    $content = "Animal number,Acquisition number,Region,Slice,Average intensity,Standard deviation,Max,Min,Pixel area,Pixel sum,ROI file\n";
    $numrows = sizeof($data);
    for($ri = 0; $ri < $numrows; $ri++) {
      $row = $data[$ri];
      $content .= $row['animal'].",".$row['acq'].",".$row['region'].",".$row['slice'].",".round($row['avg'],4).",";
      $content .= round($row['std'],4).",".round($row['max'],4).",".round($row['min'],4).",".$row['area'].",".$row['sum'].",\"".$row['file']."\"\n";
    }

    file_put_contents($file, $content);
    $link = "Click <a href='/download.php?filename=".$filename."'>here</a> to download CSV data.";
    return $link;
  }

  function save_mhr_data_csv_file($filename,$data) {
    $file = $_SERVER['DOCUMENT_ROOT'] . "/temp/" . $filename;

    $content = "Mother,Fetus,Gestation period,Heart rate average,Standard dev,Max,Min";
    $tp_keys = array();
    for ($i=2;$i<=180;$i++) {
      $k = 'A00.mhr.v' . $i;
      $tp_keys[$k] = 1;
      $content .= ",$k";
    }
    $content .= "\n";
//print "tp_keys: " . sizeof($tp_keys)."<br />";
//var_dump($tp_keys);

    $numrows = sizeof($data);
    for($ri = 0; $ri < $numrows; $ri++) {
      $row = $data[$ri];
      $hr_list = $row['hrList'];
      $hr_list = ltrim($hr_list, "[");
      $hr_list = rtrim($hr_list, "]");
//print "Heart rate: " . $hr_list . "<br />";
//print "timepoints: " . $tp_list . "<br />";

      $tp_list = $row['tpList'];
      $tp_list = ltrim($tp_list, "[");
      $tp_list = rtrim($tp_list, "]");
      $hr_array = explode( ',', $hr_list );
      $tp_array = explode( ',', $tp_list );
//var_dump($hr_array);
//var_dump($tp_array);
//print "tp_array: " . sizeof($tp_array)."<br />";
//print "hr_array: " . sizeof($hr_array)."<br />";

      $hash = array();
      foreach ($tp_keys as $tp => $val) {
        $arr = split('v',$tp);
        // mhr file timepoints starts at index 2 so account for that 
        $tp_index = $arr[1]; 
        $hr_index = $tp_index - 2 ; 
//print "tp:$tp  tp_index:$tp_index hr_index:$hr_index tp:$tp_array[$hr_index] hr:$hr_array[$hr_index]";
//print "<br />";

          $hr = '';
          if (array_key_exists($hr_index, $hr_array)){
            $hr = $hr_array[$hr_index];
          }
          $hash[$tp] = trim($hr);
      }
//print "hash: " . sizeof($hash)."<br />";
//var_dump($hash);

      $content .= $row['mother'].",".$row['fetus'].",".$row['period'].",";
      $content .= round($row['heartRate'],2).",".round($row['heartRateStd'],2).",".round($row['heartRateMax'],2).",".round($row['heartRateMin'],2);
      $row = '';
      for ($i=2;$i<=180;$i++) {
        $key = 'A00.mhr.v' . $i;
        if (array_key_exists($key, $hash)){
          $row .= ",".$hash[$key];
        } else {
          $row .= ",";
        }
      }
      $content .= "$row\n";
    }

    file_put_contents($file, $content);
    $link = "Click <a href='/download.php?filename=".$filename."' download='".$filename."'>here</a> to download CSV data.";
    return $link;

  }

?>
