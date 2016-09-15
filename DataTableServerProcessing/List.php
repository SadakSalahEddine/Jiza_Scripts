
<?php

include_once 'model/header.php';
$where = $totalRows = $sqlRequest = "";

// initilize all variable
$params = $columns = $totalRecords = $data = array();
$params = $_REQUEST;

//$_SESSION['slh3']= $params['columns'];
//$_SESSION['slh2']= $params['columns'][0]['search']['value'];
//$_SESSION['slh']=$_REQUEST;
//var_dump($_REQUEST);


$filtre = "" ;
if (!empty($params['columns'][0]['search']['value'])){
    $filtre .= " and pre.code_cab = '".$params['columns'][0]['search']['value']."' ";
}

if (!empty($params['columns'][1]['search']['value'])){
    $filtre .= " and pre.id_nature_demande = '".$params['columns'][1]['search']['value']."' ";
}



// getting total number records without any search
//$sql = "SELECT id_preinscription , nom , prenom , cin FROM `t_preinscription` ";
$sql = "SELECT pre.id_preinscription , pre.code , pre.nom , pre.prenom , etab.abreviation as etab_abreviation,  frm.abreviation as for_abreviation , nat.designation as categorie, tbac.designation as typdes, pre.moyenne_bac  as note  FROM `t_preinscription`  pre
inner join t_preinscriptioncab precab on pre.code_cab = precab.code 
inner join ac_annee an on an.code = precab.code_annee
inner join ac_etablissement etab on etab.code = an.code_etablissement 
inner join ac_formation frm on frm.code = an.code_formation
left join x_type_bac tbac on tbac.code = pre.id_type_bac
left join  nature_demande nat  on nat.code = pre.id_nature_demande  where 1=1 $filtre";
$totalRows .= $sql;
$sqlRequest .= $sql;

$queryTot = connexion::getConnexion()->query($totalRows);
$totalRecords = $queryTot->rowCount();

$columns = array(
    0 => 'id_preinscription',
    1 => '',
    2 => 'code',
    3 => 'nom',
    4 => 'prenom',
    5 => 'etab_abreviation',
    6 => 'for_abreviation',
    7 => 'categorie',
    8 => 'typdes',
    9 => 'note',
);


 //check search value exist
//$params['search']['value']="sadak";
if (!empty($params['search']['value'])) {
   $search = $params['search']['value'];
    $where .=" and ( pre.nom LIKE '%$search%' ";
    $where .=" OR pre.prenom LIKE '%$search%' ";
    $where .=" OR etab.abreviation LIKE '%$search%' ";
    $where .=" OR frm.abreviation LIKE '%$search%' ";
    $where .=" OR nat.designation LIKE '%$search%' ";
    $where .=" OR tbac.designation LIKE '%$search%' ";
    $where .=" OR pre.moyenne_bac LIKE '%$search%' )";
}
//concatenate search sql if value exist
if (isset($where) && $where != '') {
    $totalRows .= $where;
    $sqlRequest .= $where;
}


//$params['order'][0]['column']='pre.nom';
//$params['order'][0]['dir']='pre.nom';
//$params['start'] =1;
// $params['length'] =100;
$sqlRequest .= " ORDER BY " . $columns[$params['order'][0]['column']] . "   " . $params['order'][0]['dir'] . "  LIMIT " . $params['start'] . " ," . $params['length'] . " ";

//echo $sqlRequest;


$queryRecords = connexion::getConnexion()->query($sqlRequest);



$i = 0;
foreach ($queryRecords->fetchAll(PDO::FETCH_OBJ) as $row) {
    $nestedData = array();
    $nestedData[] = ++$i;
    $cd = $row->code;
    $nestedData[] = "<input type ='checkbox' class='cat' name ='$cd' > ";
    $nestedData[] = $row->code;
    $nestedData[] = $row->nom;
    $nestedData[] = $row->prenom;
    $nestedData[] = $row->etab_abreviation;
    $nestedData[] = $row->for_abreviation;
    $nestedData[] = $row->categorie;
    $nestedData[] = $row->typdes;
    $nestedData[] = $row->note;
    $nestedData["DT_RowId"] = $cd;
    $nestedData["DT_RowClass"] = $cd;
    $data[] = $nestedData;
}


$json_data = array(
    "draw" => intval($params['draw']),
    "recordsTotal" => intval($totalRecords),
    "recordsFiltered" => intval($totalRecords),
    "data" => $data   // total data array
);

echo json_encode($json_data);  // send data as json format
?>
	