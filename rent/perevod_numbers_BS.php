<?php
include_once('../config.php');

function TreeNumber ($numberBS) {

	If (strlen($numberBS) == 1) {  //���������� ����� � ������, ���� ������ ����� ����� 100
		$numberBS = '00'.(string)$numberBS;
	}
	If (strlen($numberBS) == 2) {
		$numberBS = '0'.(string)$numberBS;
	}
	If (strlen($numberBS) == 3) {
		$numberBS = (string)$numberBS;
	}
	return $numberBS;
}



$number = 56;

?>