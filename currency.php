<?php
echo "<script charset=\"utf-8\" src='https://informers.forexpf.ru/jscripts/opengraph.js'></script>";
echo "<table width=\"186\" border=\"1\" style=\"border-collapse: collapse; text-align:center; font-size:11px\">";
echo "<tr><td style=\"color:#4B4B4B;\" colspan=\"2\" align=\"center\">";
echo "<a class=\"forexpf\" id=\"forexpf\" href=\"http://www.profinance.ru/\" style=\"font-weight:bold\">Курсы валют Forex</a><br>";
echo "<select id=\"inst1\">
	<option value=\"audusd\">AUD/USD</option>
	<option value=\"eurchf\">EUR/CHF</option>
	<option value=\"eurgbp\">EUR/GBP</option>
	<option value=\"eurjpy\">EUR/JPY</option>
	<option value=\"eurusd\" selected=\"selected\">EUR/USD</option>
	<option value=\"gbpchf\">GBP/CHF</option>
	<option value=\"gbpjpy\">GBP/JPY</option>
	<option value=\"gbpusd\">GBP/USD</option>
	<option value=\"usdcad\">USD/CAD</option>
	<option value=\"usdchf\">USD/CHF</option>
	<option value=\"usdjpy\">USD/JPY</option>
	</select>
	
	<select id=\"tictype1\">
	<option value=\"8\">TIC</option>
	<option value=\"0\" selected=\"selected\">MIN</option>
	<option value=\"1\">MIN5</option>
	<option value=\"2\">MIN15</option>
	<option value=\"9\">MIN30</option>
	<option value=\"3\">HOUR</option>
	<option value=\"10\">HOUR4</option>
	<option value=\"4\">DAY</option>
	</select>
	
	<input type=\"submit\" onclick=\"pfchm(document.getElementById('inst1').value,document.getElementById('tictype1').value);\" name=\"submitt\" id=\"submitt\" value=\"Показать\"></td></tr></table>";   

















?>