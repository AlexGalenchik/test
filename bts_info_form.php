<?php
// входные параметры
$id=$_GET['id'];

// основной запрос
$sql="SELECT";
$sql.= " bts_number";
$sql.= ",site_type";
$sql.= ",place_owner";
$sql.= ",cooperative";
$sql.= ",construction_2g_types.construction_type as construction_type_2g";
$sql.= ",construction_3g_types.construction_type as construction_type_3g";
$sql.= ",construction_4g_types.construction_type as construction_type_4g";
$sql.= ",construction_5g_types.construction_type as construction_type_5g"; //5G Добавлено
$sql.= ",model_type_2g";
$sql.= ",model_type_3g";
$sql.= ",model_type_4g";
$sql.= ",model_type_5g"; //5G Добавлено
$sql.= ",container_type";
$sql.= ",cupboard_2g_count";
$sql.= ",cupboard_3g_count";
$sql.= ",cupboard_4g_count";
$sql.= ",cupboard_5g_count"; //5G Добавлено
$sql.= ",plan_gsm.gsm_config as plan_gsm_config";
$sql.= ",plan_dcs.dcs_config as plan_dcs_config";
$sql.= ",work_gsm.gsm_config as work_gsm_config";
$sql.= ",work_dcs.dcs_config as work_dcs_config";
$sql.= ",install_gsm.gsm_config as install_gsm_config";
$sql.= ",install_dcs.dcs_config as install_dcs_config";
$sql.= ",plan_umts.umts_config as plan_umts_config";
$sql.= ",work_umts.umts_config as work_umts_config";


$sql.= ",plan_umts9.umts900_config as plan_umts9_config";
$sql.= ",work_umts9.umts900_config as work_umts9_config";

$sql.= ",plan_lte800.lte_800_config as plan_lte800_config"; //Добавлено LTE800
$sql.= ",work_lte800.lte_800_config as work_lte800_config"; //Добавлено LTE800

$sql.= ",plan_lte.lte_config as plan_lte_config";
$sql.= ",work_lte.lte_config as work_lte_config";
$sql.= ",plan_lte2600.lte_2600_config as plan_lte2600_config"; //Используется таблица lte_2600_configs 11.12.2019
$sql.= ",work_lte2600.lte_2600_config as work_lte2600_config"; //Используется таблица lte_2600_configs 11.12.2019

$sql.= ",plan_5g.5g_config as plan_5g_config"; //5G Добавлено
$sql.= ",work_5g.5g_config as work_5g_config"; //5G Добавлено


$sql.= ",plan_IoT.IoT_config as plan_IoT_config"; //Используется таблица IoT_configs 11.12.2019
$sql.= ",work_IoT.IoT_config as work_IoT_config"; //Используется таблица IoT_configs 11.12.2019
$sql.= ",iot_client";

$sql.= ",power_type";
$sql.= ",battery_capacity";
$sql.= ",power_cupboard_count";
$sql.= ",longitudel_s";
$sql.= ",longitudel_d";
$sql.= ",notes";
$sql.= ",lac_2g"; 
$sql.= ",rnc.rnc_number as number_rnc"; //
$sql.= ",bsc.bsc_number as number_bsc"; //
$sql.= ",lac_3g";  
$sql.= ",focl_2g";
$sql.= ",rent_2g";
$sql.= ",focl_3g";
$sql.= ",rent_3g";
$sql.= ",focl_U900";
$sql.= ",rent_U900";
$sql.= ",focl_LTE";
$sql.= ",rent_LTE";
$sql.= ",tac_LTE"; // Добавлено для 4g
$sql.= ",settlements.type";
$sql.= ",settlement";
$sql.= ",area";
$sql.= ",region";
$sql.= ",street_type";
$sql.= ",street_name";
$sql.= ",house_type";
$sql.= ",house_number";
$sql.= ",selsovet"; //Добавлено при корректировке адресов
$sql.= ",date_gsm_on";
$sql.= ",date_gsm_off";
$sql.= ",date_dcs_on";
$sql.= ",date_dcs_off";
$sql.= ",date_umts_on";
$sql.= ",date_umts_off";
$sql.= ",date_umts900_on";
$sql.= ",date_umts900_off";
$sql.= ",date_LTE800_on"; //LTE800 добавлен
$sql.= ",date_LTE800_off"; //LTE800 добавлен
$sql.= ",date_LTE_on";
$sql.= ",date_LTE_off";
$sql.= ",date_LTE2600_on";
$sql.= ",date_LTE2600_off";

$sql.= ",date_5g_on";  //5G Добавлено
$sql.= ",date_5g_off"; //5G Добавлено

$sql.= ",date_IoT_on";
$sql.= ",date_IoT_off";
$sql.= ",G";
$sql.= ",D";
$sql.= ",U";
$sql.= ",U9";
$sql.= ",L8"; //LTE800 добавлен
$sql.= ",L18";
$sql.= ",L26";
$sql.= ",5G"; //5G Добавлено
$sql.= ",IoT";
$sql.= ",die_bs";
$sql.= ",nas_punkt";
$sgl.=",sanpasport_num";
$sgl.=",sanpasport_date";
$sgl.=",protocol_num";
$sgl.=",protocol_date";
$sgl.=",zakluchenie_num";
$sgl.=",zakluchenie_date";
$sql.=",bbu3900";
$sql.=",bbu3910";
$sql.=",bbu2g";
$sql.=",bbu3g";
$sql.=",singlebbu";

$sql.=",razresheniya_2g.permissionUseDateTrueTo as 2g_razr_fin_date";    //Блок Разрешений
$sql.=",razresheniya_2g.category as 2g_category";
$sql.=",razresheniya_3g.permissionUseDateTrueTo as 3g_razr_fin_date";
$sql.=",razresheniya_3g.category as 3g_category";
$sql.=",razresheniya_u900.permissionUseDateTrueTo as u900_razr_fin_date";
$sql.=",razresheniya_u900.category as u900_category";
$sql.=",razresheniya_iot.permissionUseDateTrueTo as iot_razr_fin_date"; //Блок Разрешений
$sql.=",razresheniya_iot.category as iot_category";

$sql.= " FROM bts";

$sql.= " LEFT JOIN razresheniya_2g";			//Блок Разрешений
$sql.= " ON bts.Id = razresheniya_2g.bts_id";
$sql.= " LEFT JOIN razresheniya_3g";
$sql.= " ON bts.Id = razresheniya_3g.bts_id";
$sql.= " LEFT JOIN razresheniya_u900";
$sql.= " ON bts.Id = razresheniya_u900.bts_id";
$sql.= " LEFT JOIN razresheniya_iot";
$sql.= " ON bts.Id = razresheniya_iot.bts_id"; //Блок Разрешений

$sql.= " LEFT JOIN rnc";
$sql.= " ON bts.rnc_id=rnc.Id";

$sql.= " LEFT JOIN bsc";
$sql.= " ON bts.bsc_id=bsc.Id";

$sql.= " LEFT JOIN construction_2g_types";
$sql.= " ON bts.construction_2g_type_id=construction_2g_types.id";

$sql.= " LEFT JOIN construction_3g_types";
$sql.= " ON bts.construction_3g_type_id=construction_3g_types.id";

$sql.= " LEFT JOIN construction_4g_types";
$sql.= " ON bts.construction_4g_type_id=construction_4g_types.id";

$sql.= " LEFT JOIN construction_5g_types"; 
$sql.= " ON bts.construction_5g_type_id=construction_5g_types.id";  //5G Добавлено

$sql.= " LEFT JOIN gsm_configs plan_gsm";
$sql.= " ON bts.plan_gsm_config_id=plan_gsm.id";
$sql.= " LEFT JOIN dcs_configs plan_dcs";
$sql.= " ON bts.plan_dcs_config_id=plan_dcs.id";
$sql.= " LEFT JOIN gsm_configs work_gsm";
$sql.= " ON bts.work_gsm_config_id=work_gsm.id";
$sql.= " LEFT JOIN dcs_configs work_dcs";
$sql.= " ON bts.work_dcs_config_id=work_dcs.id";
$sql.= " LEFT JOIN gsm_configs install_gsm";
$sql.= " ON bts.install_gsm_config_id=install_gsm.id";
$sql.= " LEFT JOIN dcs_configs install_dcs";
$sql.= " ON bts.install_dcs_config_id=install_dcs.id";
$sql.= " LEFT JOIN umts_configs plan_umts";
$sql.= " ON bts.plan_umts_config_id=plan_umts.id";
$sql.= " LEFT JOIN umts_configs work_umts";
$sql.= " ON bts.work_umts_config_id=work_umts.id";

$sql.= " LEFT JOIN umts900_configs plan_umts9";
$sql.= " ON bts.plan_umts9_config_id=plan_umts9.id";
$sql.= " LEFT JOIN umts900_configs work_umts9";
$sql.= " ON bts.work_umts9_config_id=work_umts9.id";

$sql.= " LEFT JOIN lte_800_configs plan_lte800";			//Используется таблица lte_800_configs
$sql.= " ON bts.plan_lte800_config_id=plan_lte800.id";
$sql.= " LEFT JOIN lte_800_configs work_lte800"; 			//Используется таблица lte_configs
$sql.= " ON bts.work_lte800_config_id=work_lte800.id";

$sql.= " LEFT JOIN lte_configs plan_lte";			//Используется таблица lte_configs
$sql.= " ON bts.plan_lte_config_id=plan_lte.id";
$sql.= " LEFT JOIN lte_configs work_lte"; 			//Используется таблица lte_configs
$sql.= " ON bts.work_lte_config_id=work_lte.id";

$sql.= " LEFT JOIN lte_2600_configs plan_lte2600";	//Используется таблица lte_2600_configs
$sql.= " ON bts.plan_lte2600_config_id=plan_lte2600.id";
$sql.= " LEFT JOIN lte_2600_configs work_lte2600";  //Используется таблица lte_2600_configs
$sql.= " ON bts.work_lte2600_config_id=work_lte2600.id";

$sql.= " LEFT JOIN 5g_configs plan_5g";        //5G Добавлено
$sql.= " ON bts.plan_5g_config_id=plan_5g.id"; //5G Добавлено
$sql.= " LEFT JOIN 5g_configs work_5g";        //5G Добавлено
$sql.= " ON bts.work_5g_config_id=work_5g.id"; //5G Добавлено

$sql.= " LEFT JOIN IoT_configs plan_IoT";      //Используется таблица IoT_configs
$sql.= " ON bts.plan_IoT_config_id=plan_IoT.id";
$sql.= " LEFT JOIN IoT_configs work_IoT";      //Используется таблица IoT_configs
$sql.= " ON bts.work_IoT_config_id=work_IoT.id";

$sql.= " LEFT JOIN power_types";
$sql.= " ON bts.power_type_id=power_types.id";
$sql.= " LEFT JOIN settlements";
$sql.= " ON bts.settlement_id=settlements.id";
$sql.= " LEFT JOIN areas";
$sql.= " ON settlements.area_id=areas.id";
$sql.= " LEFT JOIN regions";
$sql.= " ON areas.region_id=regions.id";

$sql.= " WHERE bts.Id=".NumOrNull($id); 

$query = mysql_query($sql) or die(mysql_error());
$row = mysql_fetch_array($query);

$sql = "SELECT";
$sql.= " num";
$sql.= ",sectors.tech_type";
$sql.= ",antenna_type";
$sql.= ",antenna_count";
$sql.= ",height";
$sql.= ",azimuth";
$sql.= ",tm_slope";
$sql.= ",te_slope";
$sql.= ",cable_type";
$sql.= ",cable_length";
$sql.= ",ret_type";
//$sql.= ",msu_type"; 
$sql.= " FROM sectors, antenna_types WHERE";
$sql.= "     sectors.antenna_type_id=antenna_types.id";
$sql.= " AND sectors.tech_type in ('2g','gsm','dcs')"; 
$sql.= " AND bts_id=$id ORDER BY num,sectors.id"; 
$query2 = mysql_query($sql) or die(mysql_error()); 

$sql = "SELECT";
$sql.= " num";
$sql.= ",sectors.tech_type";
$sql.= ",antenna_type";
$sql.= ",antenna_count";
$sql.= ",height";
$sql.= ",azimuth";
$sql.= ",tm_slope";
$sql.= ",te_slope";
$sql.= ",cable_type";
$sql.= ",cable_length";
$sql.= ",ret_type";
//$sql.= ",msu_type";
$sql.= " FROM sectors, antenna_types WHERE";
$sql.= "     sectors.antenna_type_id=antenna_types.id";
$sql.= " AND sectors.tech_type='umts 2100'"; 
$sql.= " AND bts_id=$id ORDER BY num,sectors.id"; 
$query3 = mysql_query($sql) or die(mysql_error()); 

$sql = "SELECT";
$sql.= " num";
$sql.= ",sectors.tech_type";
$sql.= ",antenna_type";
$sql.= ",antenna_count";
$sql.= ",height";
$sql.= ",azimuth";
$sql.= ",tm_slope";
$sql.= ",te_slope";
$sql.= ",cable_type";
$sql.= ",cable_length";
$sql.= ",ret_type";
//$sql.= ",msu_type";
$sql.= " FROM sectors, antenna_types WHERE";
$sql.= "     sectors.antenna_type_id=antenna_types.id";
$sql.= " AND sectors.tech_type='umts 900'"; 
$sql.= " AND bts_id=$id ORDER BY num,sectors.id"; 
$query6 = mysql_query($sql) or die(mysql_error()); 

$sql = "SELECT";
$sql.= " num";
$sql.= ",sectors.tech_type";
$sql.= ",antenna_type";
$sql.= ",antenna_count";
$sql.= ",height";
$sql.= ",azimuth";
$sql.= ",tm_slope";
$sql.= ",te_slope";
$sql.= ",cable_type";
$sql.= ",cable_length";
$sql.= ",ret_type";
//$sql.= ",msu_type";
$sql.= " FROM sectors, antenna_types WHERE";
$sql.= "     sectors.antenna_type_id=antenna_types.id";
$sql.= " AND sectors.tech_type in ('lte 1800','lte 2600','lte 800')"; //Добавлена технология LTE800 еще
$sql.= " AND bts_id=$id ORDER BY tech_type,sectors.id";
$query7 = mysql_query($sql) or die(mysql_error());

$sql = "SELECT";    //5G Добавлено
$sql.= " num";
$sql.= ",sectors.tech_type";
$sql.= ",antenna_type";
$sql.= ",antenna_count";
$sql.= ",height";
$sql.= ",azimuth";
$sql.= ",tm_slope";
$sql.= ",te_slope";
$sql.= ",cable_type";
$sql.= ",cable_length";
$sql.= ",ret_type";
//$sql.= ",msu_type";
$sql.= " FROM sectors, antenna_types WHERE";
$sql.= "     sectors.antenna_type_id=antenna_types.id";
$sql.= " AND sectors.tech_type='5G'"; // Поиск по технологии
$sql.= " AND bts_id=$id ORDER BY tech_type,sectors.id";
$query8 = mysql_query($sql) or die(mysql_error());

$sql = "SELECT p1.bts_number ";
$sql.= ",IF(p1.id=p2.bts_id_point1,height_point1,height_point2) as height ";
$sql.= ",IF(p1.id=p2.bts_id_point1,diam_point1,diam_point2) as diam ";
$sql.= ",IF(p1.id=p2.bts_id_point1,azimuth_point1,azimuth_point2) as azimuth ";
$sql.= ",p3.bts_number as bts_number2 ";
$sql.= ",IF(p1.id=p2.bts_id_point2,height_point1,height_point2) as height2 ";
$sql.= ",IF(p1.id=p2.bts_id_point2,diam_point1,diam_point2) as diam2 ";
$sql.= ",IF(p1.id=p2.bts_id_point2,azimuth_point1,azimuth_point2) as azimuth2 ";
$sql.= ",fr_range,stream_total,stream_work,reserve,equipment ";
$sql.= "FROM (SELECT bts_number,id FROM bts WHERE bts.id=$id) p1 ";
$sql.= "JOIN (SELECT * FROM rrl) p2 ";
$sql.= "ON p1.id=p2.bts_id_point1 OR p1.id=p2.bts_id_point2 ";
$sql.= "JOIN (SELECT bts_number, id FROM bts) p3 ";
$sql.= "ON (p3.id=p2.bts_id_point1 OR p3.id=p2.bts_id_point2) AND p1.id<>p3.id ORDER BY bts_number2";
$query4=mysql_query($sql) or die(mysql_error());

$sql = "SELECT *";
$sql.= " FROM hardware WHERE";
$sql.= " bts_id=$id"; 
$query5 = mysql_query($sql) or die(mysql_error()); 



// формируем элементы

$foto = "<a href=\"file:///P:/ОЧПИОС/%20с%20temscell%20Фото/!ВКЛЮЧЕННЫЕ/".$row['bts_number']."\">БС ".$row['bts_number']."</a>"; //Работает только в IE. Из-за политики безопасности Chrome Не открывает внешние папки

$info1 = array (
	
	
	
   $row['site_type'] => "<b>".$row['bts_number']."</b><span style=\"color: blue;font: bold 12px Arial\">&nbsp;&nbsp;&nbsp;".$row['die_bs']."</span>"
  ,'адрес' =>  FormatAddressSelsovet($row['type'],$row['settlement'],$row['street_type'],$row['street_name'],$row['house_type'],$row['house_number'],$row['selsovet'],$row['area'],$row['region'])
  ,'<span style="color: red;">тип нас. пункт</span>' => '<span style="color: blue;">'.$row['nas_punkt'].'</span>'  
  ,'размещение' => $row['place_owner']
  ,'кооперация' => $row['cooperative']
  ,'тип металлоконструкции 2G' => $row['construction_type_2g'] 
  ,'тип металлоконструкции 3G' => $row['construction_type_3g']
  ,'тип металлоконструкции 4G' => $row['construction_type_4g']
  ,'тип металлоконструкции 5G' => $row['construction_type_5g'] //5G Добавлено
  ,'модель 2G' => $row['model_type_2g']
  ,'модель 3G' => $row['model_type_3g']
  ,'модель 4G' => $row['model_type_4g']
  ,'модель 5G' => $row['model_type_5g'] //5G Добавлено
  ,'тип контейнера' => $row['container_type']
  ,'Сан.Паспорт' => $row['san_pasport_num']
  ,'Протокол' => $row['protocol_num']
  ,'Заключение' => $row['zacluchenie_num']
  ,'<span style="color: blue;">BSC</span>' => $row['number_bsc']
  ,'<span style="color: blue;">RNC</span>' => $row['number_rnc']
  ,'<span style="color: blue;">LAC 2G</span>' => $row['lac_2g']
  ,'<span style="color: blue;">LAC 3G</span>' => $row['lac_3g']
  ,'<span style="color: blue;">TAC 4G</span>' => $row['tac_LTE']
 
  
  
  );
  
  
$info2 = array (
  //'тип металлоконструкции' => $row['construction_type_2g']
  //,'модель' => $row['model_type_2g']
  //,'тип контейнера' => $row['container_type']
  //,'кол-во шкафов' => $row['cupboard_2g_count']
  //,'Дата включения GSM'=> $row['date_gsm_on']
  //,'ДЕМОНТАЖ GSM'=> $row['date_gsm_off']
  //,'Дата включения DCS'=> $row['date_dcs_on']
  //,'ДЕМОНТАЖ DCS'=> $row['date_dcs_off']
  
   
);
$table1 = array (
   array ('',' gsm','  dcs')
  ,array ('планируемая конфигурация',$row['plan_gsm_config'],$row['plan_dcs_config'])
  //,array ('установленная конфигурация',$row['install_gsm_config'],$row['install_dcs_config'])
  //,array ('рабочая конфигурация',$row['work_gsm_config'],$row['work_dcs_config'])
  
);  
$info3 = array (
  //'тип металлоконструкции' => $row['construction_type_3g']
  //,'модель' => $row['model_type_3g']
  //,'кол-во шкафов' => $row['cupboard_3g_count']
  //,'Дата включения UMTS'=> $row['date_umts_on']
  //,'ДЕМОНТАЖ UMTS'=> $row['date_umts_off']  
  //,'Дата включения UMTS900'=> $row['date_umts900_on']
  //,'ДЕМОНТАЖ UMTS900'=> $row['date_umts900_off']
);
$table2 = array (
   array ('',' umts 2100','  umts 900')
  ,array ('планируемая конфигурация',$row['plan_umts_config'],$row['plan_umts9_config'])
  //,array ('рабочая конфигурация',$row['work_umts_config'],$row['work_umts9_config'])
);
$info7 = array (
  '<br/>Клиент IoT ' => "<b><span style=\"color: blue;\">".$row['iot_client']."</span></b>"
  //,'модель' => $row['model_type_4g']
  //,'кол-во шкафов' => $row['cupboard_4g_count']
  //,'Дата включения LTE1800' => $row['date_LTE_on']
  //,'ДЕМОНТАЖ LTE1800' => $row['date_LTE_off']   
  //,'Дата включения LTE2600' => $row['date_LTE2600_on']
  //,'ДЕМОНТАЖ LTE2600' => $row['date_LTE2600_off']
  //,'Дата включения IoT' => $row['date_IoT_on']
  //,'ДЕМОНТАЖ IoT' => $row['date_IoT_off']     
  
); 
$table7 = array (
   array ('',' <span style=color:red;>LTE 800</span>',' LTE 1800',' LTE 2600','  IoT') 
  ,array ('планируемая конфигурация',$row['plan_lte800_config'],$row['plan_lte_config'],$row['plan_lte2600_config'],$row['plan_IoT_config'])
  //,array ('рабочая конфигурация',$row['work_lte_config'],$row['work_lte2600_config'],$row['work_IoT_config'])
  
);

$info8 = array (  //5G Добавлено
  //'тип металлоконструкции' => $row['construction_type_5g']
  //,'модель' => $row['model_type_5g']
  //,'кол-во шкафов' => $row['cupboard_5g_count']
  //,'Дата включения UMTS'=> $row['date_5g_on']
  //,'ДЕМОНТАЖ UMTS'=> $row['date_5g_off']       
  
); 

$table12 = array (  //5G Добавлено
   array ('',' 5G') 
  ,array ('планируемая конфигурация',$row['plan_5g_config'])
    
);

$info4 = array (
   'тип питания' => $row['power_type']
  ,'ёмкость аккумуляторов' => $row['battery_capacity']
  ,'кол-во шкафов питания' => $row['power_cupboard_count']
);

if (!empty($row['longitudel_d'])) {
  $geo = MyGeoToDisplay($row['longitudel_s'])." СШ&nbsp;&nbsp;&nbsp;".MyGeoToDisplay($row['longitudel_d'])." ВД"; 
  $dec_geo = "N".MyGeoToDecDisplay($row['longitudel_s'])."&nbsp;&nbsp;&nbsp;E".MyGeoToDecDisplay($row['longitudel_d']);
}

$info5 = array (
   'координаты' => $geo
  ,'десятичные координаты' => $dec_geo
  ,'примечание' => $row['notes']
);

//2G

$table3 = array (
   array ('номер','стандарт','тип антенны','кол-во','высота','азимут','tm','te','тип каб.','длина каб.')
); 
for ($i=0; $i<mysql_num_rows($query2); $i++) {
  $row2 = mysql_fetch_array($query2);
  $table3[] = array(
     $row2['num']
    ,$row2['tech_type']
    ,$row2['antenna_type']
    ,$row2['antenna_count']
    ,$row2['height']
    ,ZeroOnEmpty($row2['azimuth'])
    ,ZeroOnEmpty($row2['tm_slope'])
    ,ZeroOnEmpty($row2['te_slope'])
    ,$row2['cable_type']
    ,$row2['cable_length']
    //,$row2['msu_type']
  ); 
}

//3G U2100

$table4 = array (
   array ('номер','стандарт','тип антенны','кол-во','высота','азимут','tm','te','тип каб.','длина каб.','ret')
); 
for ($i=0; $i<mysql_num_rows($query3); $i++) {
  $row2 = mysql_fetch_array($query3);
  $table4[] = array(
     $row2['num']
    ,$row2['tech_type']
    ,$row2['antenna_type']
    ,$row2['antenna_count']
    ,$row2['height']
    ,ZeroOnEmpty($row2['azimuth'])
    ,ZeroOnEmpty($row2['tm_slope'])
    ,ZeroOnEmpty($row2['te_slope'])
    ,$row2['cable_type']
    ,$row2['cable_length']
    ,$row2['ret_type']
    //,$row2['msu_type']
  ); 
}
    
//U900	
	
$table8 = array (
   array ('номер','стандарт','тип антенны','кол-во','высота','азимут','tm','te','тип каб.','длина каб.','ret')
); 
for ($i=0; $i<mysql_num_rows($query6); $i++) {
  $row2 = mysql_fetch_array($query6);
  $table8[] = array(
     $row2['num']
    ,$row2['tech_type']
    ,$row2['antenna_type']
    ,$row2['antenna_count']
    ,$row2['height']
    ,ZeroOnEmpty($row2['azimuth'])
    ,ZeroOnEmpty($row2['tm_slope'])
    ,ZeroOnEmpty($row2['te_slope'])
    ,$row2['cable_type']
    ,$row2['cable_length']
    ,$row2['ret_type']
    //,$row2['msu_type']
  ); 
}  

//LTE 1800 + LTE 2600 + LTE 800

$table9 = array (
   array ('номер','стандарт','тип антенны','кол-во','высота','азимут','tm','te','тип каб.','длина каб.','ret')
); 
for ($i=0; $i<mysql_num_rows($query7); $i++) {
  $row2 = mysql_fetch_array($query7);
  $table9[] = array(
     $row2['num']
    ,$row2['tech_type']
    ,$row2['antenna_type']
    ,$row2['antenna_count']
    ,$row2['height']
    ,ZeroOnEmpty($row2['azimuth'])
    ,ZeroOnEmpty($row2['tm_slope'])
    ,ZeroOnEmpty($row2['te_slope'])
    ,$row2['cable_type']
    ,$row2['cable_length']
    ,$row2['ret_type']
    //,$row2['msu_type']
  );
}

//5G сектора

$table13 = array (
   array ('номер','стандарт','тип антенны','кол-во','высота','азимут','tm','te','тип каб.','длина каб.','ret')
); 
for ($i=0; $i<mysql_num_rows($query8); $i++) {  //5G Добавлено
  $row2 = mysql_fetch_array($query8);
  $table13[] = array(
     $row2['num']
    ,$row2['tech_type']
    ,$row2['antenna_type']
    ,$row2['antenna_count']
    ,$row2['height']
    ,ZeroOnEmpty($row2['azimuth'])
    ,ZeroOnEmpty($row2['tm_slope'])
    ,ZeroOnEmpty($row2['te_slope'])
    ,$row2['cable_type']
    ,$row2['cable_length']
    ,$row2['ret_type']
    //,$row2['msu_type']
  );
}

//Добавить 5G             
			 
  //echo "bsc будет браться с кроссировок<br>";
  //echo "lac 2G<br>";
  //echo "<br>";
  //echo "rnc будет браться с кроссировок<br>";
  //echo "lac 3G<br>";
  //echo "<br>";
  
$info6 = array (
   '2G привязывается по ВОЛС' => ($row['focl_2g']==1? 'да' : '')
  ,'3G привязывается по ВОЛС' => ($row['focl_3g']==1? 'да' : '')
  ,'U900 привязывается по ВОЛС' => ($row['focl_U900']==1? 'да' : '')
  ,'LTE привязывается по ВОЛС' => ($row['focl_LTE']==1? 'да' : '')
  ,'2G привязывается по аренде РУП "Белтелеком"' => ($row['rent_2g']==1? 'да' : '')
  ,'3G привязывается по аренде РУП "Белтелеком"' => ($row['rent_3g']==1? 'да' : '')
  ,'U900 привязывается по аренде РУП "Белтелеком"' => ($row['rent_U900']==1? 'да' : '')
  ,'LTE привязывается по аренде РУП "Белтелеком"' => ($row['rent_LTE']==1? 'да' : '')
);  

$table5 = array (
   array ('п.1','выс.1','диам.1','азим.1','п.2','выс.2','диам.2','азим.2','тип РРС','поток','резерв','оборудов.')
); 
for ($i=0; $i<mysql_num_rows($query4); $i++) {
  $row2 = mysql_fetch_array($query4);
  $table5[] = array(
     "БС".$row2['bts_number']
    ,$row2['height']
    ,$row2['diam']
    ,$row2['azimuth']
    ,"БС".$row2['bts_number2']
    ,$row2['height2']
    ,$row2['diam2']
    ,$row2['azimuth2']
    ,$row2['fr_range']
    ,$row2['stream_total']
    ,$row2['reserve']
    ,str_replace('Pasolink','',$row2['equipment'])
  ); 
}

$table6 = array (
   array ('','оборудование','кол-во')
); 
for ($i=0; $i<mysql_num_rows($query5); $i++) {
  $row2 = mysql_fetch_array($query5);
  $table6[] = array(
     ''
    ,$row2['equipment']
    ,$row2['quantity']
  ); 
}

//Таблица вывода информации по датам включения и выключения, технологиям и Разрешениям

If (($row['2g_razr_fin_date']) < date("Y-m-d")) {
	$gsm_dcs = "<span style=\"color:red;\">".$row['2g_razr_fin_date']."</span>";
} else {
	$gsm_dcs = "<span style=\"color:green;\">".$row['2g_razr_fin_date']."</span>";
}

If (($row['3g_razr_fin_date']) < date("Y-m-d")) {
	$umts = "<span style=\"color:red;\">".$row['3g_razr_fin_date']."</span>";
} else {
	$umts = "<span style=\"color:green;\">".$row['3g_razr_fin_date']."</span>";
}

If (($row['u900_razr_fin_date']) < date("Y-m-d")) {
	$u900 = "<span style=\"color:red;\">".$row['u900_razr_fin_date']."</span>";
} else {
	$u900 = "<span style=\"color:green;\">".$row['u900_razr_fin_date']."</span>";
}

If (($row['iot_razr_fin_date']) < date("Y-m-d")) {
	$iot = "<span style=\"color:red;\">".$row['iot_razr_fin_date']."</span>";
} else {
	$iot = "<span style=\"color:green;\">".$row['iot_razr_fin_date']."</span>";
}

$table10 = array (
   array ('Техн.','On','Вкл.','Выкл.','Раб.Конф.','Разреш End','тип')
  ,array ('GSM',$row['G'],'<span style=font-size:11px;>'.$row['date_gsm_on'].'</span>','<span style=font-size:11px;>'.$row['date_gsm_off'].'</span>',$row['work_gsm_config'],'<span style=font-size:11px;>'.$gsm_dcs.'</span>',substr($row['2g_category'],0,1))
  ,array ('DCS',$row['D'],'<span style=font-size:11px;>'.$row['date_dcs_on'].'</span>','<span style=font-size:11px;>'.$row['date_dcs_off'].'</span>',$row['work_dcs_config'],'<span style=font-size:11px;>'.$gsm_dcs.'</span>',substr($row['2g_category'],0,1))
  ,array ('UMTS',$row['U'],'<span style=font-size:11px;>'.$row['date_umts_on'].'</span>','<span style=font-size:11px;>'.$row['date_umts_off'].'</span>',$row['work_umts_config'],'<span style=font-size:11px;>'.$umts.'</span>',substr($row['3g_category'],0,1))
  ,array ('U900',$row['U9'],'<span style=font-size:11px;>'.$row['date_umts900_on'].'</span>','<span style=font-size:11px;>'.$row['date_umts900_off'].'</span>',$row['work_umts9_config'],'<span style=font-size:11px;>'.$u900.'</span>',substr($row['u900_category'],0,1))
  ,array ('<span style=color:red;>LTE800</span>',$row['L8'],'<span style=font-size:11px;>'.$row['date_LTE800_on'].'</span>','<span style=font-size:11px;>'.$row['date_LTE800_off'].'</span>',$row['work_lte800_config'],'<b>BeCloud</b>','')
  ,array ('LTE1800',$row['L18'],'<span style=font-size:11px;>'.$row['date_LTE_on'].'</span>','<span style=font-size:11px;>'.$row['date_LTE_off'].'</span>',$row['work_lte_config'],'<b>BeCloud</b>','')
  ,array ('LTE2600',$row['L26'],'<span style=font-size:11px;>'.$row['date_LTE2600_on'].'</span>','<span style=font-size:11px;>'.$row['date_LTE2600_off'].'</span>',$row['work_lte2600_config'],'<b>BeCloud</b>','')
  ,array ('IoT',$row['IoT'],'<span style=font-size:11px;>'.$row['date_IoT_on'].'</span>','<span style=font-size:11px;>'.$row['date_IoT_off'].'</span>',$row['work_IoT_config'],'<span style=font-size:11px;>'.$iot.'</span>',substr($row['iot_category'],0,1))
  ,array ('5G',$row['5G'],'<span style=font-size:11px;>'.$row['date_5g_on'].'</span>','<span style=font-size:11px;>'.$row['date_5g_off'].'</span>',$row['work_5g_config'],'','')  									//5G Добавлено
  
);

$table11 = array (
   array ('БС '.$row['die_bs'])
  ,array ('Документ',' Номер','   Дата')
  ,array ('Сан. Паспорт',$row['sanpasport_num'],$row['sanpasport_date'])
  ,array ('Протокол',$row['protocol_num'],$row['protocol_date'])
  ,array ('Заключение',$row['zakluchenie_num'],$row['zakluchenie_date'])
    
);


// блок списка кнопок действий
if ($bm == 'w' || ($fm == 'w' && $_SESSION['enable_to_edit'] == 1) ) {
	
    
	
  $info=array (
     'Редактировать Общие Данные' => "index.php?f=3&id=$id"
    ,'Редактировать Конфиг и Даты вкл./выкл.' => "index.php?f=7&id=$id"
    ,'Редактировать Сектора' => "index.php?f=8&id=$id"
    ,'Редактировать Транспорт' => "index.php?f=9&id=$id"
    ,'Редактировать Доп. Оборудов.' => "index.php?f=18&id=$id"
	,'<span style="color:red;">Hardware (New)</b>' => "index.php?f=55&id=$id"
	,'Разрешения' => "index.php?f=43&id=$id"
	,'Документы' => "index.php?f=40&id=$id"
	,'История Изменений' => "index.php?f=16&cat=bts&id=$id"
	
);
  ActionBlock($info);
}

// кнопки списка действий доп. информации
//$info=array (
//  'История Изменений' => "index.php?f=16&cat=bts&id=$id"
//);
//AdInfoBlock($info);


// вывод элементов интерфейса
echo "<div>";
echo "  <div id='info_left_indent'>";  

InfoBlock('bts_info_block',$info=array($info1),'<span style="color: red;">Базовая станция</span>',$table10);
InfoBlock('bts_info_block',$info=array($info2),'<span style="color: red;">2G</span>',$table1);
InfoBlock('bts_info_block',$info=array($info3),'<span style="color: red;">3G</span>',$table2);
InfoBlock('bts_info_block',$info=array($info7),'<span style="color: red;">4G 800 / 1800 / 2600 + IoT</span>',$table7);
InfoBlock('bts_info_block',$info=array($info8),'<span style="color: red;">5G</span>',$table12);
InfoBlock('bts_info_block',$info=array($info4),'<span style="color: red;">Питание</span>');
InfoBlock('bts_info_block',$info=array($info5),'<span style="color: red;">Координаты</span>');
InfoBlock('bts_info_block',$info=array(),'<span style="color: red;">Доп. оборудование</span>',$table6);
echo "  </div>";
echo "  <div id='info_right_indent'>"; 
InfoBlock('bts_ad_info_block',$info=array(),'<span style="color: red;">сектора 2G</span>',$table3);
InfoBlock('bts_ad_info_block',$info=array(),'<span style="color: red;">сектора 3G UMTS 2100</span>',$table4);
InfoBlock('bts_ad_info_block',$info=array(),'<span style="color: red;">сектора 3G UMTS 900</span>',$table8);
InfoBlock('bts_ad_info_block',$info=array(),'<span style="color: red;">сектора 4G LTE 800 / 1800 / 2600</span>',$table9);
InfoBlock('bts_ad_info_block',$info=array(),'<span style="color: red;">сектора 5G</span>',$table13);
InfoBlock('bts_ad_info_block',$info=array($info6),'<span style="color: red;">транспорт</span>',$table5);

echo "  </div>";

echo "</div>";
?>

